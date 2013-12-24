@extends('layouts.default')
@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h1>Firefly
            <small>The current state of affairs</small>
        </h1>
            <div class="btn-group">
                <a href="{{URL::Route('addtransaction')}}"
                   class="btn btn-default"><span
                        class="glyphicon glyphicon-plus-sign"></span> Add
                    transaction</a>
                <a href="{{URL::Route('addtransfer')}}"
                   class="btn btn-default"><span
                        class="glyphicon glyphicon-plus-sign"></span> Add
                    transfer</a>
            </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6">
        <h4>Accounts</h4>
    </div>
    <div class="col-lg-6 col-md-6">
        <h4>Transactions</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3">
        <div id="home-accounts-chart"></div>
    </div>
    <div class="col-lg-3 col-md-3">
        <table class="table table-condensed table-bordered">
            @foreach($accounts as $account)
            <tr>
                <td><a href="{{$account['url']}}">{{$account['name']}}</a
                        ></td>
                <td class="lead" style="text-align:right;">{{mf
                    ($account['current'],true)}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-lg-6 col-md-6">
        <table class="table table-condensed table-bordered">
            @foreach($transactions as $t)
            <tr>
                <td>{{$t->date->format('j F Y')}}</td>
                <td><a href="{{URL::Route('edittransaction',$t->id)}}">{{$t->description}}</a>
                </td>
                <td>{{mf($t->amount,true)}}
            </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4"><h4>Beneficiaries</h4></div>
    <div class="col-lg-4 col-md-4"><h4>Budgets</h4></div>
    <div class="col-lg-4 col-md-4"><h4>Categories</h4></div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div
            id="home-beneficiary-piechart"></div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div id="home-budget-piechart"></div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div
            id="home-category-piechart"></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4">
        <table class="table table-condensed">
            @foreach($beneficiaries as $b)
            <tr
            @if(isset($b['overpct']))
            class="danger"
            @endif
            >
                <td><a href="{{$b['url']}}">{{$b['name']}}</a></td>
                <td>{{mf($b['amount'],true)}}
            </tr>
            @endforeach
            <tr>
            <td><em>Total</em></td>
            <td>{{mf(0,true)}}
            </tr>
        </table>

    </div>
    <div class="col-lg-4 col-md-4">
        @foreach($budgets as $budget)
        <h5><a href="{{$budget['url']}}">{{$budget['name']}}</a></h5>

        <div class="progress progress-striped" style="height:10px;">
            @if(isset($budget['overpct']))
            <div class="progress-bar progress-bar-danger" role="progressbar"
                 aria-valuenow="{{$budget['overpct']}}" aria-valuemin="0"
                 aria-valuemax="100" style="width: {{$budget['overspent']}}%;">
            </div>
            @endif
            @if(isset($budget['spent']))
            <div class="progress-bar progress-bar-warning" role="progressbar"
                 aria-valuenow="{{$budget['spent']}}" aria-valuemin="0"
                 aria-valuemax="100" style="width: {{$budget['spent']}}%;">
                <span class="sr-only">{{$budget['spent']}}% or something</span>
            </div>
            @endif
            @if(isset($budget['left']))
            <div class="progress-bar progress-bar-success" role="progressbar"
                 aria-valuenow="{{$budget['left']}}" aria-valuemin="0"
                 aria-valuemax="100" style="width: {{$budget['left']}}%;">
                <span class="sr-only">{{$budget['left']}}% Complete</span>
            </div>
            @endif
        </div>
        <p>
            <small>
                @if($budget['limit'])
                Limit: {{mf($budget['limit'])}}.
                @endif
                @if(isset($budget['overspent']))
            <span class="text-danger">Spent: {{mf($budget['amount']*-1)}}
                .</span>
                @else
                Spent: {{mf($budget['amount']*-1)}}.
                @endif
            </small>
        </p>
        @endforeach
        <table class="table table-condensed">
            <tr>
                <td><em>Total</em></td>
                <td>{{mf(0,true)}}</td>
            </tr>

        </table>
    </div>
    <div class="col-lg-4 col-md-4">
        <table class="table table-condensed">
            @foreach($categories as $c)
            <tr
            @if(isset($c['overpct']))
            class="danger"
            @endif
            >
            <td><a href="{{$c['url']}}">{{$c['name']}}</a></td>
            <td>{{mf($c['amount'],true)}}
                </tr>
                @endforeach
                <tr>
                    <td><em>Total</em></td>
                    <td>{{mf(0,true)}}
                </tr>
        </table>

    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12"><h4>Other months</h4>

        @foreach($history as $h)
        <a class="btn btn-info" style="margin:4px;"
           href="{{$h['url']}}">{{$h['title']}}</a>
        @endforeach
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    var month = {{$today->format('n')}};
    var year = {{$today->format('Y')}};
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="/js/home.js"></script>
@endsection