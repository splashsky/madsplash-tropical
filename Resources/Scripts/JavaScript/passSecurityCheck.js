$(document).ready(function() 
{
	var strPassword;
	var charPassword;
	var complexity = $("#security");
	var minPasswordLength = 8;
	var baseScore = 0, score = 0;
	
	var num = {};
	num.Excess = 0;
	num.Upper = 0;
	num.Numbers = 0;
	num.Symbols = 0;

	var bonus = {};
	bonus.Excess = 3;
	bonus.Upper = 4;
	bonus.Numbers = 5;
	bonus.Symbols = 8;
	bonus.Combo = 0; 
	bonus.FlatLower = 0;
	bonus.FlatNumber = 0;
	
	outputResult();
	$("#password").bind("keyup", checkVal);

function checkVal()
{
	init();
	
	if (charPassword.length >= minPasswordLength)
	{
		baseScore = 50;	
		analyzeString();	
		calcComplexity();		
	}
	else
	{
		baseScore = 0;
	}
	
	outputResult();
}

function init()
{
	strPassword= $("#password").val();
	charPassword = strPassword.split("");
		
	num.Excess = 0;
	num.Upper = 0;
	num.Numbers = 0;
	num.Symbols = 0;
	bonus.Combo = 0; 
	bonus.FlatLower = 0;
	bonus.FlatNumber = 0;
	baseScore = 0;
	score =0;
}

function analyzeString ()
{	
	for (i=0; i<charPassword.length;i++)
	{
		if (charPassword[i].match(/[A-Z]/g)) {num.Upper++;}
		if (charPassword[i].match(/[0-9]/g)) {num.Numbers++;}
		if (charPassword[i].match(/(.*[!,@,#,$,%,^,&,*,?,_,~])/)) {num.Symbols++;} 
	}
	
	num.Excess = charPassword.length - minPasswordLength;
	
	if (num.Upper && num.Numbers && num.Symbols)
	{
		bonus.Combo = 25; 
	}

	else if ((num.Upper && num.Numbers) || (num.Upper && num.Symbols) || (num.Numbers && num.Symbols))
	{
		bonus.Combo = 15; 
	}
	
	if (strPassword.match(/^[\sa-z]+$/))
	{ 
		bonus.FlatLower = -15;
	}
	
	if (strPassword.match(/^[\s0-9]+$/))
	{ 
		bonus.FlatNumber = -35;
	}
}
	
function calcComplexity()
{
	score = baseScore + (num.Excess*bonus.Excess) + (num.Upper*bonus.Upper) + (num.Numbers*bonus.Numbers) + (num.Symbols*bonus.Symbols) + bonus.Combo + bonus.FlatLower + bonus.FlatNumber;
	
}	
	
function outputResult()
{
	if ($("#password").val()== "")
	{ 
		complexity.html("&nbsp;").removeClass("weak strong stronger strongest").addClass("default");
	}
	else if (charPassword.length < minPasswordLength)
	{
		complexity.html("&nbsp;").removeClass("strong stronger strongest").addClass("weak");
	}
	else if (score<50)
	{
		complexity.html("&nbsp;").removeClass("strong stronger strongest").addClass("weak");
	}
	else if (score>=75 && score<95)
	{
		complexity.html("&nbsp;").removeClass("stronger strongest").addClass("strong");
	}
	else if (score>=100 && score<145)
	{
		complexity.html("&nbsp;").removeClass("strongest").addClass("stronger");
	}
	else if (score>=180)
	{
		complexity.html("&nbsp;").addClass("strongest");
	}
}

}
); 