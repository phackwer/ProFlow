$(document).ready(function ()
{
	
	$('.header-navigation-menu').hide();

	$('.header-navigation-links').mouseover(function()
	{
		$(this).find('.header-navigation-menu').show();
	});

	$('.header-navigation-links').mouseout(function()
	{
		$(this).find('.header-navigation-menu').hide();
	});

	$('.header-navigation-system-links').mouseover(function()
	{
		$(this).find('.header-navigation-menu').show();
	});

	$('.header-navigation-system-links').mouseout(function()
	{
		$(this).find('.header-navigation-menu').hide();
	});
	
	$('.header-navigation-menu-item').mouseover(function()
	{
		$(this).find('a').css('color', '#FFFFFF');
	});
	
	$('.header-navigation-menu-item').mouseout(function()
	{
		$(this).find('a').css('color', '#000000')
	});
	
	$('.header-navigation-menu-item').click(function()
	{
		window.location = $(this).find('a').attr('href');
	});

})