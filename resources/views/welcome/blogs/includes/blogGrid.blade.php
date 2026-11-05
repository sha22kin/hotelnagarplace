
 
  <article class="blog-card">
                        <div class="blog-img-wrap">
                            <img src="{{asset($post->image())}}" alt="Garment Production" class="img-fluid blog-img">
                            <div class="blog-date-badge">
                                <span class="blog-date-day">{{ $post->created_at->format('d') }}</span>
                                <span class="blog-date-month">{{ $post->created_at->format('M') }}</span>
                            </div>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-meta">
                                <span class="blog-category"><i class="fa-solid fa-folder-open"></i> Manufacturing</span>
                                <span class="blog-author"><i class="fa-solid fa-user"></i> Admin</span>
                            </div>
                            <h3 class="blog-title"><a href="{{route('blogView',$post->slug?:'no-title')}}">{{$post->name}}</a></h3>
                            <p class="blog-excerpt">{{$post->short_description}}</p>
                            <a href="{{route('blogView',$post->slug?:'no-title')}}" class="blog-read-more">Read More <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>