<?
// ������� "<?" ������ ���� �������(!) � �����. �.�. �� ������ �����, ��
// �������� �� �������� "<?" ������� ������, ����� �� ����� ��������
// header - �������� warning'�

unset($t);
session_start();
include("data/config_shop.php"); //���������� ���� ������������

// �������� � ����� ���������� ���������, 
// ���� �� � ���������� - ���� �� �������
if(!$_GET[sub]){$sub="shop";} 


/*
   ������� ���������� � ������� ����� �����, ��� $n - ��� ����� ������
   � shop.txt. �����, � ������� ����������� �� ����� ������, � ����� ID
   �� shop.txt � ������������ �����������. ���� ����� ��� ����������,
   �� ������� ����� �� ��������.
*/

function tadd($n,$sub) {
   global $t, $sub;

   // ������� ����
   $f=file("data/shop/$sub.txt") or die(header("Location: $PHP_SELF?c=error"));
   // � �������� ������ ������ � ������� (� ������ $o)
   $o=explode("|",$f[$n]);

   $id=$o[0];
   if (isset($t[all][$id])) return; // ���� ����� ��� � ������� - �����

   $t[all][$id]=$id;    // ����, ��������� ��������, ����� ��������� ����
                        // �� ����������, ��� ����� ��� ���� � �������
   $t[$id][name]=$o[2]; // ������������
   $t[$id][info]=$o[3]; // ���� ������
   $t[$id][cena]=$o[1]; // ����
   $t[$id][kol]=1;      // ���-�� � ������ ����� "1 �����"

   session_register("t"); // �������� ���������� � ������
}


/*
   ������ ������� � �������� � �������. �� ����� shop.txt �� ������ ������
   �������� ������� � �� �����. �������� ������ (� ������ ������ ������
   ��������/����/���-��) ������� �� ������.
*/
function korzina() {
   global $t,$PHP_SELF,$SID,$config_use_valut;

   $ogl=explode("|",$f[0]);

   echo "<form action=$PHP_SELF? method=POST>".
        "<input type=hidden name=c value=kolvo>".
   // ������ ��������� ������� � ��������:
        "<table id=basket><tr><td class=basket_head>����, $config_use_valut</td><td class=basket_head>������������</td><td class=basket_head>���-��</td><td class=basket_head>�������</td></tr>";
   // �������� ������ $t[all] �� ������ ��� ������
  if(count($t)==1 or $t==""){echo "<tr><td class=basket_td align=center colspan=4>���� ������� �����...</td></tr>";}
  else{$k=@array_keys($t[all]);
     for ($i=0; $i<count($k); $i++) { //>
      $id=$k[$i];
      echo "<tr><td class=basket_td>{$t[$id][cena]}</td><td class=basket_td >{$t[$id][name]}</td>".
           "<td class=basket_td><input size=4 type=text name=v[$id] value={$t[$id][kol]}></td>".
           "<td class=basket_td><a href=$PHP_SELF?c=del&id=$id>�������</a></td></tr>";
   }
}
   // ����� ������� ��� ������:
   //   ���������� - ��������� ��������� ����� ������� � �������� ��������
   //   ����� - ����. ���. + ������� �� �������� ���������� ������
   if(count($t)==1 or $t==""){$disabled="disabled";}
   echo "<tr><td colspan=2><input type=submit name=edit value='������ ���������' $disabled><input type=submit name=zakaz value='�������� �����' $disabled></td>
         <td colspan=2 align=right><a href='$PHP_SELF?c=delete'><input type=button value='�������� �������' $disabled></a></td></tr></table></form>";
}
//////////////////////////////////////////////////////////////////////////////////
/*
   ������� �� ����� ������� � ��������.
*/
function price() {
include("data/config_shop.php");
   global $t, $PHP_SELF, $sub;
   $f=file("data/shop/$sub.txt") or die(header("Location: $PHP_SELF?c=error")); // ������ ����
    $ogl=explode("|",$f[0]);
    $x=(count($ogl)-1); // ��������� ����� �����������? �� ������� ��������
   $y=count($f);   // � ����� ����� � ��������� ������
   $num_p=ceil(($y-1)/$e);

if ($sub!="shop" & !$_GET[shf]){
echo "<form action=$PHP_SELF method=POST>
      <input type=hidden name=c value=add>
  	  <table width='100%' height='95%' border='0'><tr><td colspan='$colomn'>";

//����� ������ ������������ �� ������ ������
echo "<table width='100%' border='0'><tr><td width='60%'>$ogl[0] &nbsp;</td><td>"; // ����� �������� �������
   for ($i=1; $i<=$x; $i++) {
    $subr=explode("::",$ogl[$i]);
    echo"<a href='?sub=$subr[1]'>$subr[0]</a> <br>";            // ����� �����������
   }
echo "</td></tr></table></td></tr><tr>";

$d=intval($_GET['d']);
if($d<=0 or $d>($y-1)){$d=1;}
$b=($d+$e);
   for ($i=$d; $i<$b; $i++) {
      $a=explode("|",$f[$i]); // ������ ��������� ������ �����
      if (count($a)<2) continue; // ���� ��� ������ (�����), ����������
      echo "<td><table border='0'>";
      // ���� ������ ���� ������� ������� ������ �������
      for ($j=0; $j<1; $j++) { if($a[5]!=''){$a[5]="<tr><td align=center><a title='".$a[2]."' href='?shf=".($i+1)."&sub=".$sub."'><img alt=".$a[2]." border='0' src=".$a[5]."></a></td></tr>";}
      							if($a[2]!=''){$a[2]="<tr><td align=center><b><a title='���������' href='?shf=".($i+1)."&sub=".$sub."'>".$a[2]."</a></b></td></tr>";}
      							if($a[3]!=''){$a[3]="<tr><td>".$a[3]."</td></tr>";}
      							if($a[1]!=''){$a[1]="<tr><td>����: $a[1] $config_use_valut</td></tr>";}
          echo "$a[5]";
          echo "$a[2]";
          echo "$a[3]";
          echo "$a[1]";
          }

echo "</table><a title='�������� � �������' href='?c=add&v[$i]=$i&sub=$sub'><img border='0' src='skins/images/cart_navy.gif' alt='�������� � �������'></a></td>";

                if ($i%$colomn==0){echo "</tr><tr>";}
   }
   echo "<tr  valign='bottom'><td height='100%' colspan='$colomn'>";
   // ������ ������� ��������
   if($num_p!=0 & $num_p!=1){print"��������: ";
    for ($l=1; $l<=$num_p; $l++) {
     $num_p_t=floor($b/$e);
     $num_p_s=($e*($l-1)+1);
     if($l==$num_p_t){print"[<b>$l</b>]";}else{print"[<a href='?d=$num_p_s&sub=".$sub."'>$l</a>]";}
    }
   }
   echo "</td></tr></table></form>";
}elseif ($_GET[shf]){
  echo "<form action=$PHP_SELF method=POST><input type=hidden name=c value=add>
  		<table width='100%' border='0'><tr>
	    <td><table border='0' width='100%'>"; 
	    $i=($_GET[shf]-1);
	    if($i>$y or $i<1){exit(header("Location: $PHP_SELF?"));}//�������� ���������� �� ����� �����
	$a=explode("|",$f[$i]); // ������ ������ ������ ����� ��� ������ ���������� ��������
	if($a[5]!=''){$a[5]="<tr><td><img alt=".$a[2]." border='0' src=".$a[5]."></td></tr>";}
	if($a[4]!=''){$a[4]="<tr><td>".$a[4]."</td></tr>";}else{$a[4]="<tr><td>".$a[3]."</td></tr>";}
	if($a[1]!=''){$a[1]="<tr><td>����: $a[1] $config_use_valut</td></tr>";}
          echo "<tr><td><b>$a[2]</b></td></tr>";
          echo "$a[5]";
          echo "$a[4]";
          echo "$a[1]";
          echo "</table><a title='�������� � �������' href='?c=add&v[$i]=$i&sub=$sub'><img border='0' src='skins/images/cart_navy.gif' alt='�������� � �������'></a>";
   echo "</td></tr></table></form>";
 }else{  //����� ������� �������� ��������
   echo"<table border='0' width='100%'><tr>";
    for ($i=1; $i<=$x; $i++) {
    $subr=explode("::",$ogl[$i]); if(trim($subr[2])==''){$subr[2]='noimg.jpg';}else{$subr[2]=trim($subr[2]);}
    echo"<td align='center' valign='bottom'><a href='?sub=$subr[1]'><img alt='$subr[0]' border='0' src='data/upimages/$subr[2]'><br><h1>$subr[0]</h1></a><br>"; // ����� ��������
      // ������� ����������
      if(file_exists("data/shop/$subr[1].txt")){
       $sub_f=@file("data/shop/$subr[1].txt"); // ������ ����
       $sub_ogl=@explode("|",$sub_f[0]);
       $sub_x=(@count($sub_ogl)-1); // ��������� ����� �����������? �� ������� ��������
        for ($sub_i=1; $sub_i<=$sub_x; $sub_i++) {
         $sub_subr=@explode("::",$sub_ogl[$sub_i]);
         echo"<a href='?sub=$sub_subr[1]'>$sub_subr[0]</a><br>"; // ����� �����������
        }
      }
    echo"</td>";
    if(!($i%2)){echo"</tr><tr>";}
    }
   echo"</tr></table>";
   echo "<li><a href='$PHP_SELF?do=shop&c=korzina'>������� �������</a>";
 }
}

/*
   ������� �� ����� ��������� ����� (��������). ������� �������� ����������
   ��� ������ ������.
*/
function summa() {
   global $t, $config_use_valut;
   // ������������ ������ ������� ������� �� �������
   $k=@array_keys($t[all]);
   for ($i=0; $i<count($k); $i++) {  //>
      $id=$k[$i];
      // ���� ������ (double), �� ������� �����������
      $summ+=(double)$t[$id][kol]*(double)$t[$id][cena];
      $summ2+=$t[$id][kol];
   }
   if($summ2==""){$summ2="0";}
   // ������ ������� ����������� ����� �� �����
   echo "<a href='$PHP_SELF?do=shop&c=korzina'>�������</a>: ������������ ������� - $i (� ���-��  $summ2 ��.), ���� -  ".sprintf("%.2f$config_use_valut",$summ);
}

/*
   ���������� ���������� post, ������� �������� ���� ��� ����������
   ����������� ��� ���������� ������. 
*/
   $post=file("data/polia.php");


/*****************************************************************************/
// �������� ��� ���������

// $c - �������� ����������, ����������� �� ������ ��������
if (!isset($c)) $c='';

switch($c) {

case "":
// ��� ���������� - ������ �����-����

   summa();// ���������� �� �������
   price(); // �����
   break;


case "error":
// ����� �������� ������
   echo "<h2>������</h2>";
	echo "<p align='center'>��������, �� �� ��������� �������������� ��������...</p>";
   // ����� 1 ������
   echo "<li><a href='javascript:history.back(1);'>��������� � ��������</a>";
   break;



case "korzina":
// ����� �������
   echo "<h2>������� �������</h2>";
   summa(); // ��. ����
   korzina(); // ������ ������� �������
   // ����� 1 ������
   echo "<li><a href='javascript:history.back(1);'>��������� � ��������</a>";
   break;


case "add":
// ���������� �� ����� ������ ������

   // � ������� $v �������� ������ ����� �������, ������� ������� ...
  $f=file("data/shop/$sub.txt") or die(header("Location: $PHP_SELF?c=error")); // ������ ����
  $y=count($f);   // ����� �����
   $k=@array_keys($v);
   for ($i=0; $i<count($k); $i++) {  //>
      // ... tadd() ����������� �� ����� � ������ � �������� � ������
      if($k[$i]>($y-1) or $k[$i]<1){exit(header("Location: $PHP_SELF?"));}//�������� ���������� �� ����� �����
      tadd($v[$k[$i]], $sub);
   }
   // ���� ������������� ������� �� ��������� �����, �����:
   // 1) � URL ��� ������� ��������� �����
   // 2) ����� �� ���� �����, ���� ���������� ������ �������� ��������
   exit(header("Location: $PHP_SELF?c=korzina"));
   // ��, � ��, ��� header �������� � exit... ��� ������ ���� ����� :-)
   break;


case "kolvo":
// ������� ���-�� �������, ����� � �������� ������� �������� ���������
// ��������� ��� �������� �����..
// �������, ��������� �������� ��� �������������� �������

   $k=@array_keys($v);
   for ($i=0; $i<count($k); $i++) {  //>
      $t[$k[$i]][kol]=abs(intval($v[$k[$i]]));
   }
   // ����� ��������� ��������� ������ �� ����� ��������
   session_register("t");

   // ����� ������ ��������. ���� ���������� �������� ������ ���������, ��
   // � ��� ��������������� ���������� $edit, ������� �������� ������
   // "��������� ���������". ���� �� �������� �����, �� ���������������
   // $post. ��������������� ������ ���� �� ���� ���� ����������.

   // ���� ��� ���� ��������, �� ����������� �� �������
   if (isset($edit)) exit(header("Location: $PHP_SELF?c=korzina"));
   // ����� ����������� �� �������� � ���������� ������
   exit(header("Location: $PHP_SELF?c=zakaz"));
   break;

case "del":
// �������� ������ �� ��� $id

   $id=intval($id);
   unset($t[$id]);
   unset($t[all][$id]);
   session_register("t");
   exit(header("Location: $PHP_SELF?c=korzina"));
   break;


case "delete":
// �������� ���� �������.. ��� � � ����. ������, ������ � ��������
// ������� id �������

   $k=@array_keys($t[all]);
   for ($i=0; $i<count($k); $i++) {   //>
      unset($t[$k[$i]]);
      unset($t[all][$k[$i]]);
   }
   session_register("t");
   exit(header("Location: $PHP_SELF?c=korzina"));


case "zakaz":
// ����� ��� ���������� ������

 $all_ways = @file("data/category_payment.txt");
  $count_payment = 0;
    foreach($all_ways as $ways_line){
    $ways_arr = explode("|", $ways_line);
    $ways_arr[1] = stripslashes( preg_replace(array("'\"'", "'\''"), array("&quot;", "&#039;"), $ways_arr[1]) );
    $ways_help_names[] = $way_arr[1];
    $ways_help_ids[] = $way_arr[0];
    $results .= "<tr><td valign=top width='6'><input name=sposob type=radio value='$ways_arr[1]' checked></td><td valign=top><b>$ways_arr[1]</b></td><td valign=top><p style='COLOR: #808080; border: 1px solid #C5C5C5;'> $ways_arr[2]</p></td></tr>";
	$count_payment ++;}

echo "<h2>���������� ������</h2>";

echo "<script> function check() {";
for ($i=1; $i<count($post); $i++) { print"p_sender = document.myform.v$i.value.toString();
		if(p_sender != '') { if(p_sender.length<3 || p_sender.length>50) {alert ('������ � ���� ".trim($post[$i])."!'); document.myform.v$i.focus();return false; }
		}
 else { alert('��������� ���� ".trim($post[$i])."!'); document.myform.v$i.focus(); return false; }"; 
}
echo "}</script>";
   echo "<form align=center name='myform' action=$PHP_SELF? method=post onSubmit='return check();'><input type=hidden name=c value=post>".
        "<input type=hidden name=SID value='$SID'>".
        "<table width=100% >";
   for ($i=1; $i<count($post); $i++) {    //>
      echo "<tr><td colspan=2><nobr>$post[$i]</nobr></td><td><input type=text size=40 name='v[$i]' id=v$i></td></tr>\n";
   }
   echo"$results";
   echo "</table><input type='submit' name='Submit' value='��������� �����'></form>";
   break;


case "post":
// ������� � ���������� ������ ����������, ��� ������� ������ ����������

   for ($i=1; $i<count($post); $i++) {       //>
      $v[$i] = htmlspecialchars(stripslashes(trim($v[$i])));
      if($v[$i]==""){exit(header("Location: $PHP_SELF?c=korzina"));}
      $post[$i]=trim($post[$i]);
      $ank.="$post[$i]: ".substr($v[$i],0,50)."<br>";

   }
// � ������ ������� �� �������
  if(!$t[all]){echo"<h2><center><br>���� ������� �����...</center></h2>"; continue;}
   $k=@array_keys($t[all]);
   for ($i=0; $i<count($k); $i++) {         //>
      $id=$k[$i];
      $msg.=($i+1).") {$t[$id][name]}  ".doubleval($t[$id][cena]) ."$config_use_valut  {$t[$id][kol]} ��.  = ".
           sprintf("%.2f",$t[$id][cena]*$t[$id][kol])." $config_use_valut \n";
   }
   $dost=$sposob;

	$fo = @fopen("data/zak.txt","a");
	$msg = ereg_replace("\r","",$msg);
	$msg = ereg_replace("\n","<br>",$msg);
	
	$date = date("d.m.Y�.,� G:i.");
    
	$string = "$date|$ank|$msg|$sposob|\r\n";
	fputs($fo,$string);
	fclose($fo);
session_unregister("t");	
if ($fo){echo"<h2>��� ����� ������<br>������� �� �������!</h2>
				�����: � ���� �������� ��� ���������...<hr>
				<table width=100% ><tr><td>������ ����������:<p> $ank </p>
										������ �������:<p> $msg </p>
										��������: $sposob</td></tr>
				</table>";
}
}
?>