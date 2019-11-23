<!DOCTYPE html>

<html>

<head>

	<title>{{trans('main.title.title')}}</title>

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>


<div class="container">

    <form method="POST" action="{{ route('post.tweet') }}" enctype="multipart/form-data">


        {{ csrf_field() }}


        @if(count($errors))

            <div class="alert alert-danger">

                <strong>Opa!</strong> {{trans('main.msg.problem')}}

                <br/>

                <ul>

                    @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="form-group">

            <label>{{trans('main.add.text')}}</label>

            <textarea class="form-control" name="tweet"></textarea>

        </div>

        <div class="form-group">

            <label>{{trans('main.add.image')}}</label>

            <input type="file" name="images[]" multiple class="form-control">

        </div>

        <div class="form-group">

            <button class="btn btn-success">{{trans('main.btn.add')}}</button>

        </div>

    </form>


    <table class="table table-bordered">

        <thead>

            <tr>

							<th width="50px">{{trans('main.th.1')}}</th>

							<th>{{trans('main.th.2')}}</th>

							<th>{{trans('main.th.3')}}</th>

							<th>{{trans('main.th.4')}}</th>

							<th>{{trans('main.th.5')}}</th>

							<th>{{trans('main.th.6')}}</th>

            </tr>

        </thead>

        <tbody>

            @if(!empty($data))

                @foreach($data as $key => $value)

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


</body>

</html>
