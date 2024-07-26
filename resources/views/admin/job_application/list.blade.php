@extends('front.layouts.app')

@section('title', 'Admin-Dashboard')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Job application</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.include.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body text-center">
                            <div class="card-body card-form">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="fs-4 mb-1">Job Applications</h3>
                                    </div>
                                    <div style="margin-top: -10px;">

                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">Job Title</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Employer</th>
                                                <th scope="col">Applied Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            @if ($jobApplications->isNotEmpty())
                                            @foreach ($jobApplications as $jobApplication)
                                                <tr class="active">
                                                    <td>
                                                        <div class="info1">
                                                            <p>{{ $jobApplication->job->title }}</p>
                                                            {{-- <p> <strong>Applicants:</strong>  {{ $job->applications->count() }}</p> --}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info1">
                                                            <p>{{ $jobApplication->user->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info1">
                                                            <p>{{ $jobApplication->employer->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info1">{{ \Carbon\Carbon::parse($jobApplication->applied_date)->format('d M, Y') }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots">
                                                            <button class="btn btn-danger" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">

                                                                <li><a href="javascript:void(0)" onclick="deleteApplication({{ $jobApplication->id }})"
                                                                        class="dropdown-item"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i>
                                                                        Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>

                                    </table>
                                    <div> {{ $jobApplications->links() }} </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    <script type="text/javascript">
        function deleteApplication(id){
          if (confirm('Are you sure you want to delete?')) {
            $.ajax({
                type: "delete",
                url: "{{ route('admin.jobApplication.delete') }}",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    window.location.href= "{{ route('admin.job.application') }}";
                }
            });
          }
        }
    </script>
@endsection
