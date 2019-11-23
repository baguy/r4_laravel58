<div class="container">

	<center>
		<h1><i class="fab fa-twitter-square text-primary"></i></h1>
		<h2>{{$username}}</h2>
	</center>

	<hr />

	<div class='row'>
		<div class='col-4'>

			<label class="mr-2">{{trans('main.lbl.media-fav') }}</label><i class="fas fa-heart mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $media['retweet'] }}
			</span>

		</div>

		<div class='col-4'>

			<label class="mr-2">{{trans('main.lbl.media-ret') }}</label> <i class="fas fa-retweet mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $media['favoritos'] }}
			</span>

		</div>

		<div class='col-4'>

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
			{{ $quantidade }} {{ trans('main.info.latest') }}
		</p>
	</center>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th width="50px" class="table-active">{{trans('main.th.1')}}</th>

                <th>{{trans('main.th.2')}}</th>

                <th>{{trans('main.th.3')}}</th>

                <th>{{trans('main.th.4')}}</th>

                <th>{{trans('main.th.5')}}</th>

                <th>{{trans('main.th.6')}}</th>

								<th>{{trans('main.th.7')}}</th>

            </tr>

        </thead>

        <tbody>

            @if(!empty($timeline))

                @foreach($timeline as $key => $value)

										@if($value['id_str'] == $v0 )
											<tr class="table-success">
										@elseif(
												$value['id_str'] == $v1 or $value['id_str'] == $v2 or
												$value['id_str'] == $v3 or $value['id_str'] == $v4
											)
											<tr class="table-primary">
										@else
											<tr>
										@endif


                        <td>{{ ++$key }}</td>

                        <td>{{ $value['id_str'] }}

													@if($value['id_str'] == $v0 )
														<label>*1º mais badalado!</label>
													@elseif($value['id_str'] == $v1)
														<label>*2º mais badalado</label>
													@elseif($value['id_str'] == $v2)
														<label>*3º mais badalado</label>
													@elseif($value['id_str'] == $v3)
														<label>*4º mais badalado</label>
													@elseif($value['id_str'] == $v4)
														<label>*5º mais badalado</label>
													@endif

											  </td>

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


												<td>

													@if(!empty($value['entities']['hashtags']))

															@foreach($value['entities']['hashtags'] as $v)

																	{{ $v['text'] }}

															@endforeach

													@endif

												</td>

                    	</tr>

                @endforeach

            @else

                <tr>

                    <td colspan="6">{{trans('main.msg.no')}}</td>

                </tr>

            @endif

        </tbody>

    </table>

		<center>
			<p>
				{{ trans('main.info.latest') }}
			</p>
		</center>



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
