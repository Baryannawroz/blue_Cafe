@extends('layouts.app')

@section('title')
New Expense
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="{{ url('/all-expanse') }}" class="btn btn-default waves-effect"> All Expenses </a>
            <a href="{{ url('/add-reason') }}" class="btn btn- waves-effect">Add reason</a>
        </div>

        <h4 class="page-title">New Expense</h4>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">Accounting</a></li>
            <li class="active">Expense</li>
            <li class="active">New Expense</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="card-box">
        <form class="form-horizontal" role="form" method="post" id="expenseForm" action="{{ url('/save-expense') }}"
            data-parsley-validate novalidate>
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Cause of Expense:</label>
                <div class="col-sm-6">
                    <input type="text" name="title" required class="form-control" id="title"
                        placeholder="Cause of expense">
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Cause of Expense:</label>
                <div class="col-sm-6">
                    <select name="reason_id" id="" class="form-control">
                        @foreach ($reasons as $reason)
                        <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="date" class="col-sm-3 control-label">Date of Expense:</label>
                <div class="col-sm-6">
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="form-control" placeholder="mm/dd/yyyy"
                        id="datepicker-autoclose">
                </div>
            </div>

            <div class="form-group">
                <label for="amount" class="col-sm-3 control-label">Expense Cost:</label>
                <div class="col-sm-6">
                    <input type="text" name="expense" required data-parsley-type="number" class="form-control"
                        id="amount" placeholder="Cost">
                </div>
            </div>
            <div class="form-group">
                <label for="amount" class="col-sm-3 control-label">qasa or Casher:</label>
                <div class="col-sm-6">
             <select name="is_qas" id="" class="form-control">
                 <option value="0">casher</option>
                <option value="1">qasa</option>
             </select>
             </div>
            </div>

            <div class="form-group m-b-0 mt-2">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-success waves-effect waves-light">Save now</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra-js')
<link rel="stylesheet" href="{{ url('/dashboard/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
<script src="{{ url('/dashboard/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function () {
            // Initialize datepicker
            $("#datepicker-autoclose").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'mm/dd/yyyy'
            });

            // Set up CSRF for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });

            // Handle form submission
            var expenseForm = $("#expenseForm");
            expenseForm.on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $(this).speedPost('/save-expense', formData, message = {
                    success: {
                        header: 'New Expense Saved',
                        body: 'The new expense was saved successfully.'
                    },
                    error: {
                        header: 'Something Went Wrong',
                        body: 'There was a problem saving the expense.'
                    },
                    warning: {
                        header: 'Server Error',
                        body: 'Internal server error.'
                    }
                }, expenseForm);
            });
        });
</script>
@endsection
