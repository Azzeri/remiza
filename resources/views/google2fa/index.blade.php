@if($errors->any())
<b style="color: red">{{$errors->first()}}</b>

@endif

<div class="panel-body">
    <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <p>Wprowadź hasło jednorazowego dostępu wygenerowane przez aplikację Google Authenticator. Pamiętaj, że hasło resetuje się co 30 sekund.</p>
            <label for="one_time_password" class="col-md-4 control-label">Hasło jednorazowego dostępu</label>
            <div class="col-md-6">
                <input id="one_time_password" type="number" class="form-control" name="one_time_password" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Potwierdź
                </button>
            </div>
        </div>
    </form>
</div>
<style>
.panel-body{

}
</style>