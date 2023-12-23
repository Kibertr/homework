<?php
function o(){
    $rand = random();
    $korabl = korablik($rand);
    $block[] = $korabl[1];
    $xy[] = $korabl[0];
    $korabl2 = korablik2($block);
    $block[] = $korabl2[1];
    $xy[] = $korabl2[0];
    $color = proverka($block,$xy);
    setka($color);
}
function setka($color){
    echo '<table border="1" cellpadding="20">';
    $c=0;
    for($i=0;$i<10;$i++){
            echo '<tr>';
        for($j=0;$j<10;$j++){
            $c++;
            echo '<td bgcolor="'.$color[$c].'">'.$c.'</td>';
        }
        echo '</tr>';
    }
    echo '<table>';
}
function proverka($block,$xy){
    for($i=1;$i<=100;$i++){
        $color[]="white";
        foreach($xy as $key=>$val){
            foreach($val as $key=>$val){
                if($i==$val){
                    $color[$i]="black";
                }
            }
        }
    }
    return $color;
}
function valid($korablik,$block){
    $rand = $korablik[0];
    $position = $korablik[1];
    foreach($block as $key=>$val){
        foreach($val as $key=>$val){
            if($position==1){
                if($rand<21){
                    if($rand == $val || $rand+10 == $val || $rand+20 == $val){
                        return 0;
                    }
                }else{
                    if($rand == $val || $rand-10 == $val || $rand-20 == $val){
                        return 0;
                    }
                }

            }
            if($position==0){
                if($rand == $val || $rand+1 == $val || $rand+2 == $val){
                    return 0;
                }
            }
        }
    }
    return 1;
}
function korablik2($block){
    $korablik = random();
    $correct = valid($korablik,$block);
    if($correct==1){
        $position = $korablik[0];
        $rand = $korablik[1];
        return korablik($korablik);
    }else{
        return korablik2($block);
    }
}
function random(){
    $array[]=rand(1,100);
    $array[]=rand(0,1);
    return $array;
}
function korablik($array){
    $position = $array[1];
    $rand = $array[0];
    if($position==1){
        for($d=0;$d<3;$d++){
            if($rand<21){
                $xy[]=$rand+$d*10;
                $block[]=$rand+$d*10;// корабль
                if(($rand%10)!=0){
                    $block[]=$rand+$d*10+1;//бок корабля 
                }
                if(((($rand-1)%10)!=0)){
                    $block[]=$rand+$d*10-1;//бок корабля 
                }
                if($d==0){
                    $block[]=$rand-1*10;//сверху 
                if(((($rand-1)%10)!=0)){
                    $block[]=$rand-1*10-1;//сверху слева 
                }
                if(($rand%10)!=0){
                    $block[]=$rand-1*10+1;//сверху справа 
                }
                }
                if($d==2){
                    $block[]=$rand+($d+1)*10;//снизу 
                if(((($rand-1)%10)!=0)){
                    $block[]=$rand+($d+1)*10-1;//снизу слева 
                }
                if(($rand%10)!=0){
                    $block[]=$rand+($d+1)*10+1;//снизу справа 
                }
                }
            }else{
                $xy[]=$rand-$d*10;
                $block[]=$rand-$d*10;// корабль
                if(($rand%10)!=0){
                    $block[]=$rand-$d*10+1;//бок справа
                }
                if(((($rand-1)%10)!=0)){
                    $block[]=$rand-$d*10-1;//бок слева
                }
                if($d==0){
                    $block[]=$rand+1*10;//снизу 
                if(((($rand-1)%10)!=0)){
                    $block[]=$rand+1*10-1;//снизу слева 
                }
                if(($rand%10)!=0){
                    $block[]=$rand+1*10+1;//снизу справа 
                }
                }
                if($d==2){
                    $block[]=$rand-($d+1)*10;//сверху 
                if(((($rand-1)%10)!=0)){
                    $block[]=$rand-($d+1)*10-1;//сверху слева 
                }
                if(($rand%10)!=0){
                    $block[]=$rand-($d+1)*10+1;//сверху справа 
                }
                }
            }
        }
            return $korabl[]=[$xy,$block];
    }else{
        for($d=0;$d<3;$d++){
            if($rand%10==0 || $rand%10==9){
                if($rand%10==0){
                    $xy[]=$rand-$d;
                    $block[]=$rand-$d;// корабль
                    if($d==0){
                        if($rand<90){
                            $block[]=$rand+10;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand-10;//верх 
                        }
                    }
                    if($d==1){
                        if($rand<90){
                            $block[]=$rand+(10)-$d;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand-(10)-$d;//верх 
                        }
                    }
                    if($d==2){
                        if($rand<90){
                            $block[]=$rand+(10)-$d;//низ
                        }
                        if($rand>10){
                            $block[]=$rand-(10)-$d;//верх
                        }

                        $block[]=$rand-$d-1;//лево середина
                        if($rand<90){
                            $block[]=$rand-$d-1+10;//лево низ
                        }
                        if($rand>10){
                            $block[]=$rand-$d-1-10;//лево верх
                        }
                    }
                }
                if($rand%10==9){
                    $xy[]=$rand-$d;
                    $block[]=$rand-$d;// корабль
                    if($d==0){
                        if($rand<90){
                            $block[]=$rand+10;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand-10;//верх 
                        }

                        $block[]=$rand+$d+1;//лево середина
                        if($rand<90){
                            $block[]=$rand+$d+1+10;//лево низ
                        }
                        if($rand>10){
                            $block[]=$rand+$d+1-10;//лево верх
                        }
                    }
                    if($d==1){
                        if($rand<90){
                            $block[]=$rand+(10)-$d;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand-(10)-$d;//верх 
                        }
                    }
                    if($d==2){
                        if($rand<90){
                            $block[]=$rand+(10)-$d;//низ
                        }
                        if($rand>10){
                            $block[]=$rand-(10)-$d;//верх
                        }

                        $block[]=$rand-$d-1;//лево середина
                        if($rand<90){
                            $block[]=$rand-$d-1+10;//лево низ
                        }
                        if($rand>10){
                            $block[]=$rand-$d-1-10;//лево верх
                        }
                    }
                }
            }else{
                $xy[]=$rand+$d;
                $block[]=$rand+$d;// корабль
                if($rand%10==1 || $rand==1){
                    if($d==0){
                        if($rand<90){
                            $block[]=$rand+10;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand-10;//верх 
                        }
                    }
                    if($d==1){
                        if($rand<90){
                            $block[]=$rand+$d+10;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand+$d-10;//верх 
                        }
                    }
                    if($d==2){
                        if($rand<90){
                            $block[]=$rand+$d+10;//низ
                        }
                        if($rand>10){
                            $block[]=$rand+$d-10;//верх
                        }
                        $block[]=$rand+$d+1;//право
                        $block[]=$rand+$d+1+10;//право
                        if($rand>10){
                            $block[]=$rand+$d+1-10;//право
                        }
                    }
                }
                else{
                    if($d==0){
                        if($rand<90){
                            $block[]=$rand+10;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand-10;//верх 
                        }
                        $block[]=$rand-1;//лево середина
                        if($rand<90){
                            $block[]=$rand-1+10;//лево низ
                        }
                        if($rand>10){
                            $block[]=$rand+$d-1-10;//лево верх
                        }
                    }
                    if($d==1){
                        if($rand<90){
                            $block[]=$rand+$d+10;//низ 
                        }
                        if($rand>10){
                            $block[]=$rand+$d-10;//верх 
                        }
                    }
                    if($d==2){
                        if($rand<90){
                            $block[]=$rand+$d+10;//низ
                        }
                        if($rand>10){
                            $block[]=$rand+$d-10;//верх
                        }
                        if($rand%10!=8){
                            $block[]=$rand+$d+1;//право
                            $block[]=$rand+$d+1+10;//право
                            if($rand>10){
                                $block[]=$rand+$d+1-10;//право
                            }
                        }
                    }
                }
            }
        }
            return $korabl[]=[$xy,$block];
    }
}
?>
<div style="display:flex;justify-content:center;align-items:center;height:100vh">
<?php
o();
?>
</div>
