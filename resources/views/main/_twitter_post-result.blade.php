<div class="container">

	{{-- CABEÇALHO --}}
	<center>
		<h1><i class="fab fa-twitter-square text-primary"></i></h1>
		<h2>{{$username}}</h2>
	</center>

	<div class='row'>

		<div class='col-3'>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.last-query') }}</label><i class="fas fa-calendar-alt mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ \App\helpers\FormatterHelper::dateTimeToPtBR($at_pre['updated_at']) }}
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
	{{-- .cabeçalho --}}

	<hr />

	{{-- INFO --}}
	<div class='row'>
		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.media-fav') }}</label><i class="fas fa-heart mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $media['favoritos'] }}
			</span>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.media-ret') }}</label> <i class="fas fa-retweet mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $media['retweet'] }}
			</span>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.friends') }}</label> <i class="fas fa-user-friends mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $friends_num }}
			</span>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.friends-verified') }}</label> <i class="fas fa-user-check mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $friends_verified }}
			</span>

		</div>

	</div>


	<div class='row'>
		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.followers') }}</label> <i class="fas fa-user-plus mr-2"></i>
			<span class="badge badge-primary badge-pill">
				{{ $seguidores }}
			</span>

		</div>

		<div class='col-3'>

			{{-- <label class="mr-2">{{trans('main.lbl.fol-comparison') }}</label> --}} <i class="fas fa-user-plus mr-2"></i>
			<span class="badge {{$followers_pill_color}} badge-pill">
				@if($followers_pill_color == 'badge-danger')
					<i class='fas fa-minus'></i>
				@elseif($followers_pill_color == 'badge-success')
					<i class='fas fa-plus'></i>
				@endif
				{{ $followers_comparison }}
			</span>

		</div>

		<div class='col-3'>

			<label class="mr-2">{{trans('main.lbl.engagement') }}</label> <i class="fas fa-comments"></i>
			<span class="badge badge-primary badge-pill">
				{{ $engagement }}
			</span>

		</div>

		<div class='col-3'>

			{{-- <label class="mr-2">{{trans('main.lbl.eng-comparison') }}</label> --}} <i class="fas fa-comments"></i>
			<span class="badge {{$engagement_pill_color}} badge-pill">
				@if($engagement_pill_color == 'badge-danger')
					<i class='fas fa-minus'></i>
				@elseif($engagement_pill_color == 'badge-success')
					<i class='fas fa-plus'></i>
				@endif
				{{number_format((float)$engagement_comparison, 2, '.', '')}}
			</span>

		</div>
	</div>
	{{-- .info --}}

	<hr />

	{{-- CLASSIFICAÇÃO --}}

	{{-- Nível-engajamento --}}
	<label>{{trans('main.lbl.lvl-engagement') }}</label>
	<div class="card text-white bg-info mb-3">
		<div class="card-body">
			<blockquote class="blockquote mb-0">
				<center>
					<p>
						{{ $nivel_engajamento['description'] }}
					</p>
				</center>
			</blockquote>
		</div>
	</div>
	{{-- .nivel-engajamento --}}

	{{-- Tipo-perfil --}}
	<p>
		<label class="mr-2">{{trans('main.lbl.char') }}</label>
	</p>

	<div class='row'>

		@foreach($caracteristicas as $key => $value)
			@if($value != '')
				<div class='col-3'>
					<div class="card text-white bg-info mb-3">
						<div class="card-header">
							{{ $value['name'] }}
						</div>
						<div class="card-body">
							<blockquote class="blockquote mb-0">
								<footer class="blockquote-footer" style="color:white">
									{{ $value['description'] }}
								</footer>
							</blockquote>
						</div>
					</div>
				</div>
			@endif
		@endforeach

	</div>
	{{-- .tipo-perfil --}}

	{{-- .classificação --}}

	<hr />

	{{-- LINK --}}
	<center>
		<p>
			{{ $quantidade }} {{ trans('main.info.latest') }}
		</p>
		<p>
			<small>
				{{ trans('main.info.link') }}
				<label> https://twitter.com/{{$username}}/status/{{"<Twitter ID>"}} </label>
			</small>
		</p>
	</center>
	{{-- .link --}}

	{{-- TABELA de tweets --}}
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

                        <td>{{ $value['full_text'] }}</td>

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
		{{-- .tabela --}}

</div>

<center>
	{{-- VOLTAR --}}
	<div class="col-1">
		<span class="float-right mr-2">
			<a href="{{ URL::previous() }}">{{trans('application.btn.back')}}</a>
		</span>
	</div>
	{{-- .voltar --}}

</center>

</body>

</html>
