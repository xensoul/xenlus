<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{MAINTITLE} | {PAGETITLE}</title>
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
    
    <link rel="stylesheet" type="text/css" href="./themes/default/css/style.css" media="screen" />
    
    <script type="text/javascript" src="./core/js/jquery.js"></script>
    <script type="text/javascript" src="./core/js/jquery.dropdown.js"></script>
	{HEADERDATA}
</head>
<body>

<div id="wrap">

    <div id="header">
	    <h1><a href="index.php">{MAINTITLE}</a></h1>
	    <h2>{SLOGAN}</h2>
    </div>
    
    <div id="menu">
        <ul id="nav" class="dropdown dropdown-linear">
            {MENU}
        </ul>

    </div>
    
    <div id="content">
        <div class="left">
            {LEFTSIDEBARCONTENT}
        </div>    
        <div class="innercontent">
            <h2>{PAGETITLE}</h2>
                {PAGECONTENT}
            <br />
                {COMMENTS}
        </div>
        <div class="right">
            {RIGHTSIDEBARCONTENT}
        </div>
        <div style="clear: both;"></div>
    </div>
        
    <div id="bottom"></div>
    
    <div id="footer">
        {FOOTER}
    </div>
</div>
{ANALYTICSCODE}
</body>
</html>