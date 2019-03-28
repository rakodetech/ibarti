<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<h2>The parameters</h2>
<p>The first parameter is for the <strong>CSS selector</strong> to targets the elements on which
apply Nifty Corners. The CSS selectors accepted are: tag selector, id selector,
descendant selector (with id or class) and grouping. The following table show some
example:</p>
<table>
<thead><tr><th>Selector</th><th>Example</th></tr></thead>
<tbody>

<tr><th>tag selector</th><td>"p"<br>"h2"</td></tr>
<tr><th>id selector</th><td>"div#header"<br>"h2#about"</td></tr>
<tr><th>class selector</th><td>"div.news"<br>"span.date"<br>"p.comment"</td></tr>
<tr><th>descendant selector (with id)</th><td>"div#content h2"<br>"div#menu a"</td></tr>

<tr><th>descendant selector (with class)</th><td>"ul.news li"<br>"div.entry h4"</td></tr>
<tr><th>grouping (any number and combination of the previous selectors)</th><td>"h2,h3"<br>"div#header,div#content,div#footer"<br>"ul#menu li,div.entry li"</td></tr>
</tbody>
</table>
<p>Talking about options: they're identified by keywords and they can be specified in any
order and number. Let's see them:</p>
<table>
<thead><tr><th>keyword</th><th>meaning</th></tr></thead>

<tbody>
<tr><th>tl</th><td>top left corner</td></tr>
<tr><th>tr</th><td>top right corner</td></tr>
<tr><th>bl</th><td>bottom left corner</td></tr>
<tr><th>br</th><td>bottom right corner</td></tr>
<tr><th>top</th><td>upper corners</td></tr>
<tr><th>bottom</th><td>lower corners</td></tr>

<tr><th>left</th><td>left corners</td></tr>
<tr><th>right</th><td>right corners</td></tr>
<tr><th>all <em>(default)</em></th><td>all the four corners</td></tr>
<tr><th>none</th><td>no corners will be rounded (to use for nifty columns)</td></tr>
<tr><th>small</th><td>small corners (2px)</td></tr>
<tr><th>normal <em>(default)</em></th><td>normal size corners (5px)</td></tr>

<tr><th>big</th><td>big size corners (10px)</td></tr>
<tr><th>transparent</th><td>inner transparent, alias corners will be obtained. This option activates
automatically if the element to round does not have a background-color specified.</td></tr>
<tr><th>fixed-height</th><td>to be applied when a fixed height is set via CSS</td></tr>
<tr><th>same-height</th><td>Parameter for <em>nifty columns</em>: all elements identified by the CSS selector of the
first parameter will have the same height. If the effect is needed without rounded corners, simply use this parameter
in conjuction with the keyword <em>none</em>.</td></tr>
</tbody>

</table>
<p>We'll meet the selectors and options through the many examples I've prepared. Let's start.</p>
<h2>Example 1: a single div</h2>
<p>The <a href="nifty1.html">first example</a> has been already presented.
The code to round the div with <code>id="box"</code> is the
following:</p>
<p class="codice">
&lt;script type=&quot;text/javascript&quot; src=&quot;niftycube.js&quot;&gt;&lt;/script&gt;<br>

&lt;
script type=&quot;text/javascript&quot;&gt;<br>
window.onload=function(){<br>
<strong>Nifty(&quot;div#box&quot;,&quot;big&quot;);</strong><br>
}<br>
&lt;/script&gt;
</p>

</body>
</html>
