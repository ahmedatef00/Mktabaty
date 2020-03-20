@extends('mktabaty.layouts.single')
@section('title')
<h1>Book Title</h1>
@endsection

@section('content')
<div class="col-md-12">
    <!-- Books -->
    <div class="row">
        <div class="col-3 mt-3">
            <div class="card card-plain">
                <img class="card-img-top" src={{asset("images/".$book->image)}} alt="book image" height="300px">
            </div>
        </div>

        <div class="col-6 mt-3">

            <div class="card-body">
                <div>
                    <h4 class="card-title">{{$book->title}}</h4>
                    <h6 class="card-title">{{$book->author}}</h6>
                </div>

                <div class="star-rating">
                    @for ($i = 0; $i < $book->getRates(); $i++) <span class="fa fa-star checked commentRate"></span>
                        @endfor
                        @for ($i = 5; $i > $book->getRates() ;$i--)
                        <span class="fa fa-star  commentRate"></span>
                        @endfor
                </div>

                <p class="card-text">
                    {{$book->description}}
                </p>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary d-flex ">{{$book->available}} copies available</span>
                </div>
                <br />

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @elseif (session()->get('message'))
                @if(session()->get('message') === 'Enjoy Reading')
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @else
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                @endif

                <div>
                    @if (auth::user()->leasedBooks()->get()->contains('id',$book->id))
                    <div class="alert alert-success">
                        You already leased this book, Happy Reading :)
                    </div>
                    @elseif($book->available === 0)
                    <button type="button" class="btn btn-secondary" disabled style="cursor:not-allowed">No copies
                        available Now</button>
                    @else
                    <button class="btn btn-success" data-toggle="modal" data-target="#leaseModal"
                        data-whatever="@mdo">Lease</button>
                    @endif
                </div>
            </div>

        </div>


        @if (auth::user()->favoriteBooks()->get()->contains('id',$book->id))
        {{-- <i class="fa fa-heart fa-pull-right mb-3" aria-hidden="true"></i> --}}
        <form class="d-flex justify-content-between " action="{{ route('favs', $book->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <div class="col-3 mt-3">
                <div class="d-flex justify-content-center">
                    <input type="hidden" name="book_id" value={{$book->id}}>
                    <button type="submit" class="btn"> <i class="fa fa-heart fa-pull-right mb-3" 
                            aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
        @else
        <form class="d-flex justify-content-between " action="{{ route('fav', $book->id)}}" method="POST">
            @csrf
            <div class="col-3 mt-3">
                <div class="d-flex justify-content-center">
                    <input type="hidden" name="book_id" value={{$book->id}}>
                    <button type="submit" class="btn"> <i class="fa fa-heart-o fa-pull-right mb-3"
                            aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
        @endif

    </div>
    <!-- End of Books -->
    @if (auth::user()->rates()->get()->contains('id',$book->id))
    <div class="alert alert-success">
        You already rated this book, Thank You :)
    </div>
    @else
    <form class="d-flex justify-content-between " action="{{ route('comment', $book->id)}}" method="POST">
        <div class="form-group flex-grow-1">
            @csrf
            @method('POST')

            <textarea class="form-control" rows="5" id="comment" name="comment"
                placeholder="Your Comment..."></textarea>
            <input type="submit" class="btn btn-primary btn-block commentButton" value="Comment" />
        </div>
        <div class="starrating risingstar d-flex justify-content-center flex-row-reverse" name="rate">
            <input type="radio" id="star5" name="rate" value="5" /><label for="star5" title="5 star">5</label>
            <input type="radio" id="star4" name="rate" value="4" /><label for="star4" title="4 star">4</label>
            <input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="3 star">3</label>
            <input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="2 star">2</label>
            <input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="1 star">1</label>
        </div>
    </form>
    @endif


</div>


</div>
<!-- End write comment -->



<div class="row top-buffer">
    <div class="col-sm-12">
        <h3>Comments</h3>
    </div>
</div>

<!-- show previous comment -->


@foreach ($book->comments as $comment)
<div class="d-flex mt-3">

    <div class="thumbnail d-flex justify-content-center">
        <img class="img-responsive user-photo" src={{asset("Userimages/".$comment->user->image) }} width="100px">
    </div>
    <div class="card p-2 flex-grow-1 d-flex flex-row justify-content- align-items-start ">

        <div>
            <div>
                <div class="d-flex justify-content-arround align-items-center">
                    <div>
                        <strong>{{$comment->user['name']}}</strong>
                        <div class="star-rating d-flex justify-content-center rate">
                            @for ($i = 0; $i < $comment['rate']; $i++) <span class="fa fa-star checked commentRate">
                                </span>
                                @endfor
                                @for ($i = 5; $i > $comment['rate']; $i--)
                                <span class="fa fa-star  commentRate"></span>
                                @endfor
                        </div>
                    </div>
                </div>

                <span class="text-muted"><time datetime="2014-12-16T01:05">{{$comment['rated_at']}}</time></span>
            </div>

            <p>
                {{$comment['comment']}}
            </p>
        </div>


        <form action="{{ route('comments', $book->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="close" aria-label="Close" type="submit">
                <span aria-hidden="true">&times;</span>
            </button>
        </form>
    </div>

</div>
@endforeach




<!-- End show previous comment -->



{{-- Begining of   Lease Modal --}}
<div class="modal fade mt-5" id="leaseModal" tabindex="-1" role="dialog" aria-labelledby="leaseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaseModalLabel">Lease Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('bookLease', $book->id)}}" method="post" class="d-inline">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="lease-days" class="col-form-label">NO. of Days :</label>
                        <input type="number" class="form-control" id="lease-days" name="lease_days">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Confirm Lease</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
{{-- End of lease Modal --}}


<!-- Related Books -->

<div class=" row top-buffer mt-5">
    <div class="col-sm-12">
        <h3>Related Books</h3>
    </div><!-- /col-sm-12 -->
</div><!-- /row -->

<div class="row">

    @foreach ($book->category->books as $book)
    <div class="col-md-4 mt-4">
        <div class="card card-plain">
            <img class="card-img-top" src={{asset("images/".$book->image)}} alt="book image" height="250px">

            <div class="card-body">
                <div class="d-flex justify-content-between">

                    <h4 class="card-title"> <a href="{{route('showBook' ,['id'=> $book->id])}}"
                            class="no-decoration">{{$book->title}}</a>
                    </h4>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary d-flex ">available copies {{$book->available}} </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach


</div>

<!-- End Related Books -->



@stop