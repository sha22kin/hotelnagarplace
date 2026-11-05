@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle($kind['plural'].' List')}}</title>
@endsection @push('css')
<style type="text/css"></style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">{{$kind['plural']}} List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">{{$kind['plural']}} List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            @isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])
            <a class="btn btn-outline-primary" href="{{route('admin.'.$kind['route'].'Action',['create'])}}">Add {{$kind['single']}}</a>
            @endisset
            <a class="btn btn-outline-primary" href="{{route('admin.'.$kind['route'])}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


@include(adminTheme().'alerts')
<div class="card">
    <div class="card-content">
        <div id="accordion">
            <div
                class="card-header collapsed"
                data-toggle="collapse"
                data-target="#collapseTwo"
                aria-expanded="false"
                aria-controls="collapseTwo"
                id="headingTwo"
                style="background:#009688;padding: 15px 20px; cursor: pointer;"
            >
               <i class="fa fa-filter"></i> Search click Here..
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                <div class="card-body">
                    <form action="{{route('admin.'.$kind['route'])}}">
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{request()->search?request()->search:''}}" placeholder="{{$kind['single']}} Name" class="form-control {{$errors->has('search')?'error':''}}" />
                                    <button type="submit" class="btn btn-success btn-sm rounded-0"> <i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">{{$kind['plural']}} List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.'.$kind['route'])}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="1">Active</option>
                                <option value="2">InActive</option>
                                @isset(json_decode(Auth::user()->permission->permission, true)['pages']['delete'])
                                <option value="5">Delete</option>
                                @endisset
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <ul class="statuslist">
                            <li><a href="{{route('admin.'.$kind['route'])}}">All ({{$totals->total}})</a></li>
                            <li><a href="{{route('admin.'.$kind['route'],['status'=>'active'])}}">Active ({{$totals->active}})</a></li>
                            <li><a href="{{route('admin.'.$kind['route'],['status'=>'inactive'])}}">Inactive ({{$totals->inactive}})</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 60px;width: 60px;">
                                    <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                </th>
                                <th style="min-width: 300px;">{{$kind['single']}} Name</th>
                                <th style="min-width: 100px;">Serial</th>
                                <th style="max-width: 100px;">{{$kind['image'] ? 'Image' : 'Price'}}</th>
                                <th style="min-width: 160px;width: 160px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $i=>$item)
                            <tr>
                                <td>
                                    <input class="checkbox" type="checkbox" name="checkid[]" value="{{$item->id}}" /><br />
                                    {{$items->currentpage()==1?$i+1:$i+($items->perpage()*($items->currentpage() - 1))+1}}
                                </td>
                                <td>
                                    <span>{{$item->name}}</span><br />

                                    @if($item->status=='active')
                                    <span class="badge badge-success">Active </span>
                                    @elseif($item->status=='inactive')
                                    <span class="badge badge-danger">Inactive </span>
                                    @else
                                    <span class="badge badge-danger">Draft </span>
                                    @endif
                                    <span>
                                        <i class="fa fa-user" style="color: #1ab394;"></i>
                                        {{$item->user?$item->user->name:'No Author'}}
                                    </span>
                                    <span>
                                        <i class="fa fa-calendar" style="color: #1ab394;"></i>
                                        {{$item->created_at ? $item->created_at->format('d-m-Y') : ''}}
                                    </span>
                                </td>
                                <td>
                                    <span>{{(int) $item->view}}</span>
                                </td>
                                <td style="padding: 5px; text-align: center;">
                                    @if($kind['image'])
                                    <img src="{{asset($item->image())}}" style="max-width: 80px; max-height: 50px;" />
                                    @else
                                    <span>{{$item->seo_title}}</span>
                                    @endif
                                </td>
                                <td class="center">
                                    <a href="{{route('admin.'.$kind['route'].'Action',['edit',$item->id])}}" class="btn btn-md btn-info">Edit</a>

                                    @isset(json_decode(Auth::user()->permission->permission, true)['pages']['delete'])
                                    <a href="{{route('admin.'.$kind['route'].'Action',['delete',$item->id])}}" class="btn btn-md btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                    @endisset
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$items->links('pagination')}}
                </div>
            </form>
        </div>
    </div>
</div>


@endsection @push('js') @endpush
