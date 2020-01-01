<div class="container">

	<center>
		<h1><i class="fab fa-twitter-square text-primary"></i></h1>
		<h2>{{$username}}</h2>
	</center>

	<hr />

	<div class='row'>
		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.media-fav') }}</label><i class="fas fa-heart mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $media['retweet'] }}
			</span>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.media-ret') }}</label> <i class="fas fa-retweet mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $media['favoritos'] }}
			</span>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.verified') }}
			<span class="badge badge-primary badge-pill">
				@if($verified)
					<i class="fas fa-check-square"></i>
				@else
					<i class="fas fa-times"></i>
				@endif
			</span>

		</div>
	</div>

	<center>
		<p>
			10 {{ trans('main.info.latest') }}
		</p>
	</center>

    <table class="table table-bordered table-dark">

        <thead>

            <tr>

                <th width="50px" class="table-active">{{trans('main.th.1')}}</th>

                <th>{{trans('main.th.2')}}</th>

                <th>{{trans('main.th.3')}}</th>

                <th>{{trans('main.th.4')}}</th>

                <th>{{trans('main.th.5')}}</th>

                <th>{{trans('main.th.6')}}</th>

            </tr>

        </thead>

        <tbody>

            @if(!empty($timeline))

                @foreach($timeline as $key => $value)

                    <tr>

                        <td>{{ ++$key }}</td>

                        <td>{{ $value['id'] }}</td>

                        <td>{{ $value['text'] }}</td>

                        <td>

                            @if(!empty($value['extended_entities']['media']))

                                @foreach($value['extended_entities']['media'] as $v)

                                    <img src="{{ $v['media_url_https'] }}" style="width:100px;">

                                @endforeach

                            @endif

                        </td>

                        <td>{{ $value['favorite_count'] }}</td>

                        <td>{{ $value['retweet_count'] }}</td>

                    </tr>

                @endforeach

            @else

                <tr>

                    <td colspan="6">{{trans('main.msg.no')}}</td>

                </tr>

            @endif

        </tbody>

    </table>

</div>

<center>

	<div class="col-1">
		<span class="float-right mr-2">
			<a href="{{ URL::previous() }}">{{trans('application.btn.back')}}</a>
		</span>
	</div>

</center>

</body>

</html>
