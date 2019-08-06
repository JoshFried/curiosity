@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form action="/threads" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" class="form-control" type="text" name="title" placeholder="">
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea id="body" class="form-control" type="text" name="body" rows="8"></textarea>
                        </div>
                    
                        <button class="btn btn-primary" type="submit">Publish</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
