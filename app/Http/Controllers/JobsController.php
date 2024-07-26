<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationMail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\SavedJobs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class JobsController extends Controller
{
    // This method will show jobs page
    public function index(Request $request){

       $categories =  Category::where('status', 1)->get();
       $jobTypes =  JobType::where('status', 1)->get();

       $jobs = Job::where('status', 1);

        // search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere('title', 'like', '%'.$request->keyword.'%');
                $query->orWhere('keywords', 'like', '%'.$request->keyword.'%');
            });
        }

        // search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // search using category

        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        $jobTypeArray = [];
        // Search using Job type
        if (!empty($request->jobType)) {

           $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // search using experience

        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }


        $jobs = $jobs->with('jobType', 'category');
            if( $request->sort == '0'){
                $jobs = $jobs->orderBy('created_at', 'ASC');
            }else{
                $jobs = $jobs->orderBy('created_at', 'DESC');

            }
        $jobs = $jobs->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray,
        ]);
    }

    // This method will show job detail page

    public function detail($id){

       $jobDetail = Job::where(['id'=> $id, 'status' => 1])->with('jobType', 'category')->first();

       if ($jobDetail == null) {
            abort(404);
       }
       $count = 0;
       if (Auth::user()) {
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
       }

    //    Fetch applicant

   $applications =  JobApplication::where('job_id', $id)->with('user')->get();


       return view('front.job-detail',['jobDetail' => $jobDetail, 'count' => $count, 'applications' => $applications]);
    }

    // This method for job apply
    public function applyJob(Request $request){

            $id = $request->id;

           $job = Job::where('id', $id)->first();

        //    If job not found in DB
           if ($job == null) {
            $message = 'Job does not exist.';
            Session()->flash('error', );

                return response()->json([
                    'status'=> false,
                    'message' =>  $message
                ]);
           }

        //    You can not apply on your own job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You can not apply at your own job.';
            Session()->flash('error', $message);

            return response()->json([
                'status'=> false,
                'message' => $message
            ]);
        }

        //    You can not apply on a job twise

       $jobApplicationCount = JobApplication::where([
            'user_id'=>Auth::user()->id,
            'job_id' => $id,
        ])->count();

        if($jobApplicationCount > 0){

            $message = 'You have allready applied on this job.';
            Session()->flash('error', $message);

            return response()->json([
                'status'=> false,
                'message' => $message
            ]);

        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        // send Notification Email to Employer


        $employer = User::where('id', $employer_id)->first();

        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job
        ];

        Mail::to($employer->email)->send(new JobNotificationMail($mailData));


        $message = 'You have successfully applied.';

        Session()->flash('success', $message);

            return response()->json([
                'status'=> true,
                'message' => $message
            ]);

    }


    // This method will save the job

    public function saveJob(Request $request){

        $id = $request->id;

       $job = Job::find($id);

        if($job == null){
            Session()->flash('error','Job not found');
            return response()->json([
                'status'=> false,
            ]);
        }

        // Check if user already saved the job

       $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if($count > 0){
            Session()->flash('error','You allready on this job');
            return response()->json([
                'status'=> false,
            ]);

        }

        $savedJob = new SavedJob;

        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        Session()->flash('success','You have successfully saved the job');
            return response()->json([
                'status'=> true,
            ]);
    }



}

