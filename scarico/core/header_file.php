<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Description" content="Gestione Magazzino by Fabrizio Amorelli" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="css/normalize.min.css">
<link rel="stylesheet" href="css/defaults.min.css">
<link rel="stylesheet" href="css/nav-core.min.css">
<link rel="stylesheet" href="css/nav-layout.min.css">
<link rel="stylesheet" href="css/scroll.css">
<link rel="stylesheet" href="css/lista.css">
<link rel="stylesheet" href="css/arrow.css">

<!--[if lt IE 9]>
<link rel="stylesheet" href="css/ie8-core.min.css">
<link rel="stylesheet" href="css/ie8-layout.min.css">
<script src="js/html5shiv.min.js"></script>
<![endif]-->

<script src="js/rem.min.js"></script>

<link rel="shortcut icon" type="image/jpg" href="img/magico.jpg" />
<link rel="stylesheet" href="fonts/font-awesome.min.css">
<link rel="stylesheet" href="css/fabri3.css">

<style>

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  padding: 0;
  width: 30%;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}


.linea:hover {
	background-color:#bfbebe;
}

table th,
table td {
  padding: .625em;
  text-align: left;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media screen and (max-width: 997px) {
	
	
  table {
    border: 0;
	width: 90%;
	table-layout: fixed;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }
}

.tab_tit {
	font-size: .85em;
	letter-spacing: .1em;
	text-transform: uppercase;
	font-weight: bold;
}

</style>