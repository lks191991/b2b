<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="{{ route('dashboard') }}"> {!! config('app.name', 'newname') !!}</a>.</strong>
    All rights reserved.
	
	<a class="float-right ml-3" target="_blank" href="{{route('privacyPolicy')}}">  |&nbsp;&nbsp;&nbsp;{{ __('Privacy Policy') }}</a>
		 <a class="float-right" target="_blank"  href="{{route('termsAndConditions')}}"> {{ __('Terms and Conditions') }}</a>
</footer>