<?php
?>
<!doctype html>
<html lang="en">
    <head>
        <style>
            body{margin:0px;padding:0px;font-family:"lucida grande",verdana,sans-serif !important;background-color: #efefef;color:#000000;overflow-y: scroll;}
            body table{border-collapse:collapse;/*cellspacing = "0"*/width:100%;}
            body th, body tr, body td{padding:0;/*cellpadding = "0"*/}
            body {font-size:11px;}
            body p{font-size:11px;}
            body h1{font-size:30px;}
            body h2{font-size:24px;}
            body h3{font-size:20px;}
            body h4{font-size:18px;}
            body h5{font-size:16px;}
            body h6{font-size:14px;}
            body h1, body h2, body h3, body h4, body h5, body h6, body p{margin:0px;}
            body ul, body li{list-style:none;margin:0px;padding:0px;}
            body img{border:none; vertical-align: bottom}
            body hr{margin:0;height:1px;border: none;background: #666666;}
            a, a:visited, a:hover, a:active {color: inherit;}

            body .relative{position: relative;}
            body .absolute{position: absolute;}
            body .fixed{position: fixed;}
            body .static{position: static;}
            body .float_left{float:left;}
            body .float_right{float:right;}
            body .clear_both{clear:both;}
            body .justify{text-align: justify;}
            body .block{display: inline-block;}

            body .top{vertical-align:top;}
            body .middle{ display: table-cell; vertical-align: middle;}
            body .bottom{vertical-align:bottom;}

            body .left{text-align:left;}
            body .right{text-align:right;}
            body .center{text-align:center;}

            body .bold{font-weight:bold;}
            body .italic{font-style:italic;}
            body .underline{text-decoration:underline;}
            body .strip{text-decoration:line-through;}

            body .pointer{cursor:pointer;}

            table p,table h1,table h2,table h3,table h4,table h5,table h6{ margin:1px 5px;}
            .table_content,
            .table_content th,
            .table_content td{ border:1px #cccccc solid; }
            .table_head{background-color: #1d388d; color:#EFEFEF; height: 30px; }
            .table_content tr:nth-child(odd){ background-color: #e2f0f6;}
            .table_content tr:nth-child(even){ background-color: #ffffff;}

            .black{color:#000000;}
            .white{color:#FFFFFF;}
            .red{color:#FF0000;}
            .green{color:#00FF00;}
            .blue{color:#0000FF;}
            .yellow{color:#FFFF00;}
            .toska{color:#00FFFF;}
            .magenta{color:#FF00FF;}
            .purple{color:rgb(96, 53, 177);}
            .brown{color:#fadabf;}

            .light_grey{color:#A9A9A9;}
            .grey{color:#808080;}
            .dark_grey{color:#3D3D3D;}

            .retro_red{color:#c23836}
            .retro_orange{color:#fa5505}
            .retro_yellow{color:#fece00}
            .retro_lightgreen{color:#b1d22c}
            .retro_green{color:#89a907}
            .retro_green{color:#07a925}
            .retro_darkgreen{color:#18775e}
            .retro_toska{color:#73b19f}
            .retro_lightblue{color:#6cb8b8}
            .retro_blue{color:#61a29e}
        </style>
    </head>
    <body>
        <main>
            {{content}}
        </main>
    </body>
</html>


