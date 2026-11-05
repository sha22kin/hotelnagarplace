@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle($kind['single'].' Edit')}}</title>
@endsection @push('css')

<style type="text/css"></style>
@endpush @section('contents')
@php
    $listRoute = 'admin.'.$kind['route'];
    $actionRoute = 'admin.'.$kind['route'].'Action';
    $canAdd = isset(json_decode(Auth::user()->permission->permission, true)['pages']['add']);
@endphp

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">{{$kind['single']}} Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item"><a href="{{route($listRoute)}}">{{$kind['plural']}} </a></li>
                    <li class="breadcrumb-item active">{{$kind['single']}} Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route($listRoute)}}">BACK</a>
            @if($canAdd)
            <a class="btn btn-outline-primary" href="{{route($actionRoute,['create'])}}">Add {{$kind['single']}}</a>
            @endif
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        @include(adminTheme().'alerts')
        <form action="{{route($actionRoute,['update',$item->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">{{$kind['single']}} Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ $kind['image'] ? 'Service Name(*)' : 'Room / Package Name(*)' }} </label>
                                    <input type="text" class="form-control {{$errors->has('name')?'error':''}}" name="name" placeholder="{{ $kind['image'] ? 'Enter Service Name (e.g. AC Room)' : 'Enter Package Name (e.g. AC Room)' }}" value="{{old('name', $item->name)}}" required="" />
                                    @if ($errors->has('name'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                @unless($kind['image'])
                                <div class="form-group">
                                    <label for="heading">Box Heading</label>
                                    <input type="text" class="form-control {{$errors->has('heading')?'error':''}}" name="heading" placeholder="PACKAGE" value="{{old('heading', $item->short_description)}}" />
                                    @if ($errors->has('heading'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('heading') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control {{$errors->has('price')?'error':''}}" name="price" placeholder="Tk. 1200tk/Day" value="{{old('price', $item->seo_title)}}" />
                                    @if ($errors->has('price'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('price') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Package Facilities <small>(one per line)</small></label>
                                    <textarea name="description" rows="6" class="form-control {{$errors->has('description')?'error':''}}" placeholder="Newspaper&#10;Wi-Fi&#10;VIP Bed, Bathroom&#10;Food Facility&#10;AC Room">{{old('description', $item->description)}}</textarea>
                                    @if ($errors->has('description'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                                @endunless
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    @if($kind['image'])
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">{{$kind['single']}} Image</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">{{$kind['single']}} Image <small>(square, 600 x 600)</small></label>
                                    <input type="file" name="image" class="form-control {{$errors->has('image')?'error':''}}" />
                                    @if ($errors->has('image'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <img src="{{asset($item->image())}}" style="max-width: 100px;" />
                                    @if($canAdd && $item->imageFile)
                                    <a href="{{route('admin.mediesDelete',$item->imageFile->id)}}" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="image_alt">Image Alt Text</label>
                                    <input type="text" class="form-control {{$errors->has('image_alt')?'error':''}}" name="image_alt" placeholder="Image Alt Text" value="{{old('image_alt', $item->imageFile ? $item->imageFile->alt_text : '')}}" />
                                    @if ($errors->has('image_alt'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image_alt') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">{{$kind['single']}} Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">{{$kind['single']}} Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" {{$item->status=='active' || $item->status=='temp'?'checked':''}}/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    @if($kind['image'])
                                    <div class="form-group col-6">
                                        <label for="fetured">Square Image</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" {{$item->fetured?'checked':''}}/>
                                            <label class="custom-control-label" for="fetured">Crop</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Serial <small>(small number shows first)</small></label>
                                    <input type="number" min="0" class="form-control form-control-sm" name="view" value="{{old('view', (int) $item->view)}}">
                                    @if ($errors->has('view'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('view') }}</p>
                                    @endif
                                </div>
                                @if($canAdd)
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- Basic Inputs end -->
</div>

@endsection @push('js')

@endpush
