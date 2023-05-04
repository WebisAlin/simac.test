@if(count($errors) > 0)
	@foreach($errors->all() as $error)
		<div class='alert alert-danger'>
			<i class="fas fa-times-circle"></i> {{$error}}
		</div>
	@endforeach
@endif

@if(session('success'))
	<div class='alert alert-success'>
		<i class="fas fa-info-circle"></i> <?php
		echo session('success');
		?>
	</div>
@endif

@if(session('error'))
	<div class='alert alert-danger'>
			<i class="fas fa-times-circle"></i> {{session('error')}}
	</div>
@endif
