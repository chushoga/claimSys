<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1, minimum-scale=1, width=device-width">
		<title>Tform - 商品品番検索</title>
		<link rel="shortcut icon" href="http://www.tform.jp/favicon.ico" type="image/vnd.microsoft.icon" />
		<link rel="apple-touch-icon" href="http://www.tform.jp/device_icon.png" />
		<link rel="stylesheet" href="http://www.tform.jp/css/tform-common.php?de=&amp;v=1446199819" />
		<link rel="stylesheet" href="http://www.tform.jp/css/tform-searchform_2.css?v=1446199821" />
		<link rel="stylesheet" href="http://www.tform.jp/css/tform-responsive.css?v=1446199821" />
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,300,700,600,400" />

		
		<!--IE9より古いバージョンの場合-->
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="http://www.tform.jp/css/tform-unresponsive.css?v=1446199822" type="text/css" media="all" />
			<script src="http://www.tform.jp/js/html5shiv.js"></script>
		<![endif]-->
		<!--IE7のみ（IE6以下にも摘要させるとminmax-1.0.jsがエラーになるのでIE6以下はIE8.jsとminmax-1.0.jsの併用は禁止-->
		<!--[if IE 7]>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
		<![endif]-->
		<!--IE7より古いバージョンの場合-->
		<!--IE6以下でもmin-width、min-height、max-width、max-heightを実装する-->
		<!--[if lt IE 7]>
			<script src="http://www.tform.jp/js/minmax-1.0.js"></script>
		<![endif]-->
		<!--Google Analytics-->
		<script type="text/javascript">
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27017559-1']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 

			
</script>		<style>
			body { background: #fff; }
			#wrapper { background: #fefefe; border: none; }
			.wrap { padding: 3%; }
			#wrapper { min-height: 200px; }
			#tformLogo { width: 10%; height: auto; margin: 1% auto 2% auto; max-width: 100px; min-width: 80px; }
			.commentBox { width: 80%; max-width: 580px; margin: 4% auto; text-align: center; }
			 p { font-size: 1em; line-height: 2em; margin: 1em 0; }
			.cautionMain { font-size: 1.15em; margin-bottom: 1em; line-height: 1.8em; }
			#pageBottom { border-top: 1px solid #ddd; }
			#pageBottom p#copyright { text-align: center; float: none; }
			form#searchform_2 { margin: 4% auto 8% auto; }
			 
			@media only screen and (max-width: 580px) {
				#tformLogo {
					margin-bottom: 8%;
				}
				.commentBox {
					margin: 6% auto;
					text-align: left;
					max-width: 500px;
				}
				.pcBreak {
					display: none;
				}
				#searchform_2 {
					margin: 8% auto 18% auto;
				}
				
			 }
			
			.style-5 input[type="text"] {
			  padding: 10px;
			  border: solid 1px #fff;
			  box-shadow: inset 1px 1px 2px 0 #707070;
			  transition: box-shadow 0.3s;
			}
			.style-5 input[type="text"]:focus,
			.style-5 input[type="text"].focus {
			  box-shadow: inset 1px 1px 2px 0 #c9c9c9;
			}

			.animated { 
				position: absolute;
				width: 30px;
				left: -50px;
				top: 25%;
				color: #555;
				font-size: 2.3em;
				padding: 5px;
				line-height: 50%;
				-webkit-animation-duration: 1s; 
				animation-duration: 1s; 
				-webkit-animation-fill-mode: both; 
				animation-fill-mode: both; 
				animation-iteration-count:infinite; 
				-webkit-animation-iteration-count:infinite; 
			} 

			@-webkit-keyframes fadeInLeft { 
				0% { 
					opacity: 0; 
					-webkit-transform: translateX(-20px); 
				} 
				100% { 
					opacity: 1; 
					-webkit-transform: translateX(0); 
				} 
			} 
			@keyframes fadeInLeft { 
				0% { 
					opacity: 0; 
					transform: translateX(-20px); 
				} 
				100% { 
					opacity: 1; 
					transform: translateX(0); 
				} 
			} 
			.fadeInLeft { 
				-webkit-animation-name: fadeInLeft; 
				animation-name: fadeInLeft; 
			}
		
			#keywords_2{
				ime-mode: disabled;
			}

			[type=text] {
				height: 30px;
				width: 200px;
				line-height: 30px;
				font-size: 20px;
				margin: 0 0 5px 0;
				padding: 2px 5px;
				border: 1px solid #bababa;
			}
			textarea {
				height: 90px;
				width: 200px;
				line-height: 30px;
				font-size: 20px;
				margin: 0;
				padding: 2px 5px;
				border: 1px solid #bababa;
				font-weight: bold;
			}

		</style>
	</head>
	<body>
		<div id="wrapper">
			<div class="wrap">
				<h1 id="tformLogo"><a href="http://www.tform.jp/"><img src="http://www.tform.jp/images/common_theme/tform-logo-trans.png" alt="Tform（ティーフォルム）" /></a></h1>
				<p class="cautionRed cautionMain" style='text-align: center;'>
				ウェブサイトリニューアルに伴い、リンクが切れております。<br>
				ご不便をおかけいたしますが、下記にて品番検索いただくか、<br>
				<a href='http://www.tform.jp/'>こちら</a>をクリックしてリニューアルページへご移動ください。
				</p>
				<div class="commentBox">
									
					<br>
					<form name="searchform_2" id="searchform_2" method="get" action="http://www.tform.jp/products/search_results" style='position: relative;' class='style-5'>
						<!--<input type="hidden" name="c" value="0"/>--><!--この一行をコメントアウトしないと検索できません。そうなった原因は今はわかりません。わかりまではとりあえず残しときます。（2015.1.8）-->
						<!--<input type="hidden" name="de" value=""/>--><!--現状デザインをカテゴリごとに切り分け無いので不要-->
						<div id="animated-example" class="animated fadeInLeft">▶</div>
						<input id="keywords_2" type="text" name="no" value="" style="text-transform:uppercase; outline: solid 0px #555; ime-mode: disabled;" pattern="^(?! )[0-9a-zA-Z-]*$" title='半角英数字入力のみ' />
						<!--<input type="image" src="http://www.tform.jp/images/common_theme/searchBtn_icon.png" alt="検索" name="searchBtn" id="searchBtn_2" onClick="void(this.form.submit());return false" />-->
						
						<input type="image" src="http://www.tform.jp/images/common_theme/searchBtn_icon.png" alt="検索" name="searchBtn" id="searchBtn_2" onClick="return validate()"  />
					</form>
					
					
									
									
									<br class="pcBreak" />上記の検索窓に正しい商品の品番をご入力のうえキーボードのenterキー、
									<br class="pcBreak" />または、右側のボタンをクリックしてください。
									<p>お手数をおかけいたしますが、ブックマーク、リンク等の変更をお願いいたします。<br />
									<p><a href="javascript:history.back()">直前のページに戻る場合はこちらをクリックしてください。</a></p><br><br>
									
								</div>
					<p style='text-align: center;'>大洋金物株式会社 ティーフォルム事業部</p>
			</div><!--wrap-->
		</div><!--wrapper-->
		<footer id="pageBottom">
			<p id="copyright">
				Copyright &copy;
				2002–2015				Taiyo Kanamono Co.Ltd.
			</p>
		</footer>
				
		<!--[if (gte IE 9)|!(IE)]><!-->
			<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
			<script type="text/javascript">
				(window.jQuery || document.write('<script src="http://www.tform.jp/js/jquery-2.1.1.min.js"><\/script>'));
			</script>
		<!--<![endif]-->
		<!--[if lt IE 9]>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<script type="text/javascript">
				(window.jQuery || document.write('<script src="http://www.tform.jp/js/jquery-1.10.2.min.js"><\/script>'));
			</script>
			<script src="http://www.tform.jp/js/jquery-alert-ie8.js"></script>
		<![endif]-->

		<script src="http://www.tform.jp/js/jquery-searchform_2.js"></script><!--検索フォームの本体-->
		<script>
			$(window).on('load resize',function() {
				var tarGetWidth1 = $("form#searchform_2 input#searchBtn_2").width();
				var tarGetWidth2 = $("form#searchform_2").innerWidth();
				$("form#searchform_2 input#keywords_2").outerWidth(tarGetWidth2 - tarGetWidth1 - '2');

				var tarGetHeight = $("form#searchform_2 input#searchBtn_2").height();
				$("form#searchform_2 input#keywords_2").outerHeight(tarGetHeight);
			});
		</script>
		<script>
			$(function(){
				$("input#keywords_2, input#sidr-id-keywords_2").val("品番でリニューアルサイト内を検索")
					.css( {
						"color":"#AAA", "padding-left":"0.3em", 
						//"font-size":"10px","line-height":"1.6em","letter-spacing":"0.15em"
					} );
				$("input#keywords_2, input#sidr-id-keywords_2").focus(function() {
					if(this.value == "品番でリニューアルサイト内を検索"){
						$(this).val("").css( { "color":"#FFFFFF",
						//"font-size":"100%","line-height":"1.4em","letter-spacing":"0"
						} );
					}
				});
				$("input#keywords_2, input#sidr-id-keywords_2").blur(function(){
					if(this.value == "") {
						$(this).val("品番でリニューアルサイト内を検索")
							.css( {
							"color":"#888",
							//"font-size":"10px","line-height":"1.6em","padding-left":"0.5em","letter-spacing":"0.15em"
							} );
					}
					if(this.value != "品番でリニューアルサイト内を検索") {
						$(this).css("color","#000");
					}
				});
			});
			
						
			
		</script>
		
		<script type="text/javascript">
			var form = document.forms[0], 
				submit = document.getElementById('searchBtn_2'),
				input = document.getElementById('keywords_2');

			input.addEventListener('invalid', function(e) {
				if(input.validity.valueMissing){
					e.target.setCustomValidity("Please create a username"); 
				} else if(!input.validity.valid) {
					e.target.setCustomValidity("This is not a valid username"); 
				} 
				// to avoid the 'sticky' invlaid problem when resuming typing after getting a custom invalid message
				input.addEventListener('input', function(e){
					e.target.setCustomValidity('');
				});
			}, false);
			
			/* JQUERY STOP FROM WRITING */
			/*
			jQuery(document).ready(function() {
	
				// ime-modeが使えるか
				var supportIMEMode = ('ime-mode' in document.body.style);

				// 非ASCII
				var noSbcRegex = /[^\x00-\x7E]+/g;

				// 1バイト文字専用フィールド
				jQuery('#keywords_1')
				.on('keydown blur paste', function(e) { 

					// ime-modeが使えるならスキップ
					if (e.type == 'keydown' || e.type == 'blur')
						if (supportIMEMode) return;

					// 2バイト文字が入力されたら削除
					var target = jQuery(this);
					if(!target.val().match(noSbcRegex)) return;
					window.setTimeout( function() {
					  target.val( target.val().replace(noSbcRegex, '') );
					}, 1);        

				});

			});
			*/
		/*
			function validate()
			{
			var form = $("searchform_2");
			var regexp1=new RegExp("[^\w $\-]");
			if(regexp1.test(document.getElementById("keywords_2").value))
			{
				
				//alert("GOOD TO GO!");
				//form.submit();
				//return true;
			}
				//alert("Only alphabets from a-z are allowed");
				//return false;
			}
			*/
			</script>
	</body>
</html>

<!-- /^[a-z\d\-_\s]+$/i -- >
<!--
	<p class="cautionRed cautionMain">ウェブサイトリニューアルにともない、このページは使用できなくなりました。</p>
	<p>この画面から商品を検索される場合は、下記の検索窓に商品の品番をご入力のうえ
	<p><a href="../">Tform 新ウェブサイト トップページはこちらからご覧ください。</a></p>
	<p>お手数をおかけいたしますが、ブックマーク、リンク等の変更をお願いいたします。
	<br class="pcBreak" />URLを手入力した場合は、綴りを確認して再度お試し下さい。</p>
	<p>大洋金物株式会社 ティーフォルム事業部</p>
-->
<!--
	<h1>Object not found!</h1>
	<br />
	<h2>
	ウェブサイトリニューアルにともない、このページは使用できなくなりました。
	</h2>
	<h3><a href="/index.php">Tform 新ウェブサイト トップページ</a></h3>
	<p>お手数おかけいたしますが、ブックマーク、リンク等の変更をお願いいたします。<br />
	URLを手入力した場合は、綴りを確認して再度お試し下さい。</p>
	<h3>大洋金物株式会社 ティーフォルム事業部</h3>
	<br />
	<h2>Error 404</h2>
-->

