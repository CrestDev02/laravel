@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="clearfix mb-3">
            <div class="float-start">
                <h4>Edit User </h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User</h3>
                            </div>

                            <form method="POST" action="{{ route('user.update',$user) }}" id="edit_form">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group ">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="username" name="name" placeholder="Enter email" value="{{ old('username',$user->name) }}">
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group pt-4">
                                        <label for="email">Email address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email',$user->email) }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-outline-dark">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src= "https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script type="text/javascript">
    $.validator.addMethod("customPassword", function(value, element) {
        return this.optional(element) || /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/.test(value);
    }, "Please enter a valid password.");

    $(function(){
        $("#edit_form").validate({ 
            rules: { 
                name: { 
                    required: true, 
                    maxlength: 255
                }, 
                email: { 
                    required: true, 
                    email: true,
                    maxlength: 255,
                    remote: {
                        url:'{!! route('user.checkEmail') !!}',
                        type: "POST",
                        data: {
                            
                            _token: '{{csrf_token() }}',
                            email: function() {
                                return $("#email").val();
                            },
                            id:function() {
                                return '{!! $user->id !!}';
                            }
                        },
                    }
                }
            }, 
            // In 'messages' user have to specify message as per rules 
            messages: { 
                username: { 
                    required: "Please enter a username", 
                }, 
                email: { 
                    required: "Please enter a email", 
                    email:'Please enter a valid email',
                    remote: "This email is already taken."
                }
            },
            submitHandler: function(form) {
                form.submit();
            } 
        }); 
    });
</script>

