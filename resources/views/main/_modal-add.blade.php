<div id="modalAddComment" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ trans('application.modal.confirmation.title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>
      </div>
      <div class="modal-body">

        {{
          Form::open(
            array(
              'id' => 'mainForm',
              'route' => 'comentarios.store'
            )
          )
        }}

        <div class="form-group {{ ($errors->has('text')) ? 'has-error' : '' }}">

          {{ Form::label('text', trans('application.btn.add-new-comment')) }}

          <div class="input-group">

            {{
              Form::textarea(
                'text',
                Input::old('text'),
                array(
                  'class'            => ($errors->has('text')) ? 'form-control has-error__icon' : 'form-control',
                  'aria-describedby' => 'textAddon',
                  'rows'             => 5
                )
              )
            }}

            @if ($errors->has('text'))
            <div class="invalid-feedback">
              {{ $errors->first('text') }}
            </div>
            @endif

          </div>

        </div>

      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
