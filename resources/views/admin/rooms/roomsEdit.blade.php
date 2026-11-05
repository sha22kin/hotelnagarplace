@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Room Edit')}}</title>
@endsection @push('css')

<style type="text/css"></style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Room Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.rooms')}}">Rooms </a></li>
                    <li class="breadcrumb-item active">Room Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.rooms')}}">BACK</a>
            @isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])
            <a class="btn btn-outline-primary" href="{{route('admin.roomsAction',['create'])}}">Add Room</a>
            @endisset
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
        <form action="{{route('admin.roomsAction',['update',$room->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Room Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Room Name(*) </label>
                                    <input type="text" class="form-control {{$errors->has('name')?'error':''}}" name="name" placeholder="Enter Room Name (e.g. AC ROOM)" value="{{old('name', $room->name)}}" required="" />
                                    @if ($errors->has('name'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Room Description </label>
                                    <textarea name="short_description" rows="3" class="form-control {{$errors->has('short_description')?'error':''}}" placeholder="Enter Room Description">{{old('short_description', $room->short_description)}}</textarea>
                                    @if ($errors->has('short_description'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('short_description') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Room Facilities <small>(one per line)</small></label>
                                    <textarea name="description" rows="6" class="form-control {{$errors->has('description')?'error':''}}" placeholder="Newspaper,Wi-Fi&#10;VIP Bed, Bathroom,&#10;Food Facility&#10;AC Room">{{old('description', $room->description)}}</textarea>
                                    @if ($errors->has('description'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Room Button</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="button_text">Button Text <small>(leave empty to hide the button)</small></label>
                                    <input type="text" class="form-control {{$errors->has('button_text')?'error':''}}" name="button_text" placeholder="Book Now" value="{{old('button_text', $room->seo_title)}}" />
                                    @if ($errors->has('button_text'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('button_text') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="button_link">Button Link</label>
                                    <input type="text" class="form-control {{$errors->has('button_link')?'error':''}}" name="button_link" placeholder="/book-now" value="{{old('button_link', $room->seo_description)}}" />
                                    @if ($errors->has('button_link'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('button_link') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Room Image</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Room Image <small>(square, 600 x 600)</small></label>
                                    <input type="file" name="image" class="form-control {{$errors->has('image')?'error':''}}" />
                                    @if ($errors->has('image'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <img src="{{asset($room->image())}}" style="max-width: 100px;" />
                                    @isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])
                                    @if($room->imageFile)
                                    <a href="{{route('admin.mediesDelete',$room->imageFile->id)}}" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    @endif
                                    @endisset
                                </div>
                                <div class="form-group">
                                    <label for="image_alt">Image Alt Text</label>
                                    <input type="text" class="form-control {{$errors->has('image_alt')?'error':''}}" name="image_alt" placeholder="Image Alt Text" value="{{old('image_alt', $room->imageFile ? $room->imageFile->alt_text : '')}}" />
                                    @if ($errors->has('image_alt'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image_alt') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Room Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">Room Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" {{$room->status=='active' || $room->status=='temp'?'checked':''}}/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="fetured">Square Image</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" {{$room->fetured?'checked':''}}/>
                                            <label class="custom-control-label" for="fetured">Crop</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Serial <small>(small number shows first)</small></label>
                                    <input type="number" min="0" class="form-control form-control-sm" name="view" value="{{old('view', (int) $room->view)}}">
                                    @if ($errors->has('view'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('view') }}</p>
                                    @endif
                                </div>
                                @isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                @endisset
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
