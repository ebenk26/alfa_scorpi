<?php
    /*
        MIZONE
    */
    require '_conf.php';
    require '_func.php';

    isset( $_GET['from'] )          ? $from         = $_GET['from']         : $from         = '';
    isset( $_GET['text'] )          ? $text         = $_GET['text']         : $text         = '';
    isset( $_GET['time'] )          ? $time         = $_GET['time']         : $time         = '';
    isset( $_GET['moid'] )          ? $moid         = $_GET['moid']         : $moid         = '';
    isset( $_GET['msgid'] )         ? $msgid        = $_GET['msgid']        : $msgid        = '';
    isset( $_GET['shortcode'] )     ? $shortcode    = $_GET['shortcode']    : $shortcode    = '';
    isset( $_GET['telcoid'] )       ? $telcoid      = $_GET['telcoid']      : $telcoid      = '';

    //------- tarif dengan kondisi berbeda2 menurut operator
    $from = $_GET['from'];

    //------- potong 5 karakter pertama
    $sub_from = substr($from, 0, 5);

    $arr_prefix_indosat = array('62855', '62856', '62857', '62858', '62814', '62815', '62816');
    $arr_prefix_telkomsel = array('62811', '62812', '62813', '62821', '62822', '62823', '62852', '62853', '62851');
    $arr_prefix_xl_telkomsel = array('62811', '62812', '62813', '62821', '62822', '62823', '62852', '62853', '62851', '62817', '62818', '62819', '62859', '62877', '62878', '62831', '62832', '62838');

    if (in_array($sub_from, $arr_prefix_indosat)) {
        $tarif_konsumen = '350';
    }
    else if (in_array($sub_from, $arr_prefix_xl_telkomsel)){
        $tarif_konsumen = '350';
    }
    else{
        $tarif_konsumen = '350';
    }

    //------- reply sms
    if (in_array($sub_from, $arr_prefix_telkomsel)){
        // $reply_benar                = "[Rp.".$tarif_konsumen.",-]Terimakasih data & Kode unik Anda telah kami terima, Daftarkan juga kodemu di mizonebvs.com (Tarif data normal),CS:021-80680415(Sen-Jum:08.00-17.00)";
        $reply_benar                = "Terimakasih data & Kode unik Anda telah kami terima, Daftarkan juga kodemu di mizonebvs.com (Tarif data normal),CS:021-80680415(Sen-Jum:08.00-17.00)";
    }
    else{
        $reply_benar                = "Terimakasih data dan Kode Unik Anda telah kami terima. Daftarkan data diri & kodemu jg  di mizonebvs.com.Info CS: 021-80680415 (Senin - Jumat : 08.00 - 17.00)";
    }
    
    if (in_array($sub_from, $arr_prefix_telkomsel)){
        $reply_format_salah             = "[Rp.0]Maaf Format SMS Anda salah.Ketik:Mizone(spasi)Nama#KodeUnik#No.HP#TempatPembelian#No.KTP#Superman/Batman.CS:021-80680415/mizonebvs.com(Tarif data normal)";
    }else{
        $reply_format_salah             = "Maaf format SMS yang Anda masukkan salah. Ketik: Mizone(spasi)Nama#KodeUnik#No.HP#Tempat pembelian#No.KTP#Superman/Batman.Info CS: 021-80680415/ mizonebvs.com";
    }

    if (in_array($sub_from, $arr_prefix_telkomsel)){
        $reply_kode_unik_salah          = "[Rp.0]Terimakasih atas SMS Anda,Kode unik yang Anda kirimkan salah.Info Klik: mizonebvs.com (Tarif data normal) atau CS : 021-80680415 (Sen-Jum: 08.00 - 17.00)";
    }else{
        $reply_kode_unik_salah          = "Terimakasih atas sms Anda, Kode unik yang anda kirimkan salah. Info Klik : mizonebvs.com atau CS : 021-80680415 (Senin - Jumat : 08.00 - 17.00)";
    }

    if (in_array($sub_from, $arr_prefix_telkomsel)){
        $reply_kode_unik_sdh_terpakai   = "[Rp.0]Terimakasih atas SMS Anda,Kode unik yg Anda kirimkan sdh pernah digunakan.Info: mizonebvs.com (Tarif data normal)/CS: 021-80680415 (Sen-Jum: 08.00-17.00)";
    }else{
        $reply_kode_unik_sdh_terpakai   = "Terimakasih atas sms Anda, Kode unik yang anda kirimkan sudah pernah digunakan. Info Klik : mizonebvs.com atau CS : 021-80680415 (Senin - Jumat:08.00 - 17.00)";
    }
    
    if (in_array($sub_from, $arr_prefix_telkomsel)){
        $reply_promo_abis               = "[Rp.0]Terima kasih atas partisipasi Anda. Program telah berakhir pada tanggal 15 April 2016. Info CS: 021-80680415 (Senin-Jumat: 08.00-17.00)";
    }else{
        $reply_promo_abis               = "Terima kasih atas partisipasi Anda. Program telah berakhir pada tanggal 15 April 2016. Info CS: 021-80680415 (Senin-Jumat: 08.00-17.00)";
    }

    $reply_kode_kadaluarsa              = "Mohon maaf khusus Account INDOMARET, promo mulai berlaku tgl 7 Maret - 15 April 2016. Silahkan input kembali I-Kupon Anda saat promo INDOMARET sdg berlangsung";
    //------- reply sms


    $text                   = urldecode( $text );
    $kata_kunci_promo       = strtolower(substr($text, 0, 6));
    $text_sms_cut           = substr($text, 7);
    $array_rep_hash         = array(" #", "# ");
    $text_sms_cut           = str_replace($array_rep_hash, "#", $text_sms_cut);
    $array_rep_strange_char = array("\n", "'");
    $text_sms_cut           = str_replace($array_rep_strange_char, "", $text_sms_cut);
    $validate               = '';
    $validate_score         = 0;
    $parse_promo_text       = explode("#", $text_sms_cut);

    if ( $kata_kunci_promo ==  KATA_KUNCI_PROMO ){
        $jml_hash = substr_count( $text_sms_cut, '#' );
        if($jml_hash < 1){
            //------- tdk ada hash
            if (in_array($sub_from, $arr_prefix_indosat)){
                $output =  urlencode($reply_format_salah).','.$tarif_konsumen;
                $output_save = $reply_format_salah;
            }
            else{
                $output =  urlencode($reply_format_salah).',0';
                $output_save = $reply_format_salah;
            }
        }else if ( ($jml_hash <= 4) AND ($jml_hash >= 1) ) {
            //------- jml hash kurang
            if (in_array($sub_from, $arr_prefix_indosat)){
                $output =  urlencode($reply_format_salah).','.$tarif_konsumen;
                $output_save = $reply_format_salah;
            }
            else{
                $output =  urlencode($reply_format_salah).',0';
                $output_save = $reply_format_salah;
            }
        }// $jml_hash > 5
        else if($jml_hash > 5){
            if (in_array($sub_from, $arr_prefix_indosat)){
                $output =  urlencode($reply_format_salah).','.$tarif_konsumen;
                $output_save = $reply_format_salah;
            }
            else{
                $output =  urlencode($reply_format_salah).',0';
                $output_save = $reply_format_salah;
            }
        }// $jml_hash = 5
        else{

            //------- jml hash benar
            // $store  = str_replace(' ', '', strtolower( $parse_promo_text[0] ) );
            $array_rep = array(' ', '-', 'à');
            $array_rep2 = array(' ', '-', 'à', '.');
            $kode_unik = str_replace($array_rep, '', $parse_promo_text[1]);
            $account_store = str_replace($array_rep, '', strtolower($parse_promo_text[3]));
            $charHero = str_replace($array_rep2, '', strtolower($parse_promo_text[5]));
            $no_hp = str_replace($array_rep, '', $parse_promo_text[2]);
            $no_ktp = str_replace($array_rep, '', $parse_promo_text[4]);

            $arr_param = array(
                'kode_unik'     => $kode_unik, 
                'account_store' => $account_store,
                'from'          => $from, 
                'text'          => $text,
                'time'          => $time, 
                'shortcode'     => $shortcode, 
                'moid'          => $moid, 
                'msgid'         => $msgid,
                'telcoid'       => $telcoid
            );

            $date_end = TGL_PROMO_HABIS;

            /* cek tanggal sudah abis apa belum */
            if( strtotime( $date_end ) >= strtotime('now') ) {

                /* cek hero */
                if ((strtolower($charHero) == strtolower('batman')) || (strtolower($charHero) == strtolower('superman'))) {

                    /* cek no hp dan no ktp */
                    if (ctype_digit($no_hp) && ctype_digit($no_ktp)) {

                        if ($from == '6281802712284') {
                            //var_dump($cek_kode_unik_alfamart);
                            //exit(' -> 100 ');
                        }

                        // replace balasan format salah berdasarkan account store
                        if ($account_store == ACCOUNT_INDOMARET) {
                            if (in_array($sub_from, $arr_prefix_telkomsel)){
                                $reply_format_salah = "[Rp.0]Maaf Format SMS Anda salah.Ketik:Mizone(spasi)Nama#ikupon#No.HP#TempatPembelian#No.KTP#Superman/Batman.CS:021-80680415/mizonebvs.com(Tarif data normal)";
                            }else{
                                $reply_format_salah = "Maaf format SMS yang Anda masukkan salah. Ketik: Mizone(spasi)Nama#ikupon#No.HP#Tempat pembelian#No.KTP#Superman/Batman.Info CS: 021-80680415/ mizonebvs.com";
                            }
                        }else{
                            if (in_array($sub_from, $arr_prefix_telkomsel)){
                                $reply_format_salah = "[Rp.0]Maaf Format SMS Anda salah.Ketik:Mizone(spasi)Nama#NoTrx+KodeUnik#NoHP#TmptPmbelian#NoKTP#Superman/Batman.CS:021-80680415/mizonebvs.com(Tarif data normal)";
                            }else{
                                $reply_format_salah = "Maaf format SMS yang Anda masukkan salah.Ketik:Mizone(spasi)Nama#NoTrx+KodeUnik#No.HP#TmptPembelian#No.KTP#Superman/Batman. Info CS:021-80680415/ mizonebvs.com";
                            }
                        }

                        if ($account_store == ACCOUNT_INDOMARET) {
                            // account store indomaret
                            $sqlCekAccount = "select id, name, length_kode_unik from account_store where lower(name)=lower('$account_store') limit 1";
                            $rsCekAccount  = $conn->query($sqlCekAccount)->fetch_assoc();

                            if (!empty($rsCekAccount)) {// jika data account store ada
                                // if panjang kode unik yang diinput sama dengan panjang kode unik alfamart
                                if (strlen($kode_unik) == $rsCekAccount['length_kode_unik']) {
                                    $table = '';
                                    
                                    //kalau kode = urutan 1
                                    $sqlMap = "SELECT * 
                                        FROM  redeem 
                                        WHERE awal LIKE  '$kode_unik'";
                                    $resultMap = $conn->query($sqlMap);
                                    
                                    if($resultMap->num_rows > 0)
                                    {
                                        $rowTbl= $resultMap->fetch_assoc();   
                                        $table = $rowTbl['table'];
                                    }
                                    else
                                    {                                        
                                        //kalau kode = urutan akhir
                                        $sqlMap = "SELECT * 
                                            FROM  redeem 
                                            WHERE akhir LIKE  '$kode_unik'";
                                        $resultMap = $conn->query($sqlMap);
                                        
                                        if($resultMap->num_rows > 0)
                                        {
                                            $rowTbl=$resultMap->fetch_assoc();    
                                            $table = $rowTbl['table'];
                                        }
                                        else
                                        {
                                            //kalau kode antara awal & akhir
                                            $sqlMap = "SELECT * 
                                                FROM  redeem 
                                                WHERE STRCMP( awal,  '$kode_unik' ) =  '-1'
                                                AND STRCMP( akhir,  '$kode_unik' ) =  '1'";
                                            $resultMap = $conn->query($sqlMap);
                                            
                                            if($resultMap->num_rows > 0)
                                            {
                                                $rowTbl=$resultMap->fetch_assoc();    
                                                $table = $rowTbl['table'];

                                                $sqlCekA    = "SELECT id, redeem_status, date_from, date_to FROM ".$table." WHERE LOWER(kode_unik)=LOWER('$kode_unik') LIMIT 1";
                                                $rsCekA     = $conn->query($sqlCekA);

                                                if ($rsCekA->num_rows == 0) {
                                                    $table = 'redeem_indo8';

                                                    $sqlCekA    = "SELECT id, redeem_status, date_from, date_to FROM ".$table." WHERE LOWER(kode_unik)=LOWER('$kode_unik') LIMIT 1";
                                                    $rsCekA     = $conn->query($sqlCekA);

                                                    if ($rsCekA->num_rows == 0) {
                                                        $table = 'redeem_indo9';
                                                    }
                                                }
                                            }else{
                                                $table = 'redeem_indo8';

                                                $sqlCekA    = "SELECT id, redeem_status, date_from, date_to FROM ".$table." WHERE LOWER(kode_unik)=LOWER('$kode_unik') LIMIT 1";
                                                $rsCekA     = $conn->query($sqlCekA);

                                                if ($rsCekA->num_rows == 0) {
                                                    $table = 'redeem_indo9';
                                                }
                                            }
                                        }
                                    
                                    }

                                    $sqlCekA    = "SELECT id, redeem_status, date_from, date_to FROM ".$table." WHERE LOWER(kode_unik)=LOWER('$kode_unik') LIMIT 1";
                                    $rsCekA     = $conn->query($sqlCekA);
                                    $jml_cek_A  = $rsCekA->num_rows;
                                    $rowA       = $rsCekA->fetch_assoc();

                                    if ($jml_cek_A == 0) {
                                        
                                        /*$SQL_insertA = "INSERT INTO redeem (redeem_status, kode_unik, msisdn, redeem_date, updated) VALUES ('1', '$kode_unik', '$from', NOW(), NOW() )";
                                        $conn->query($SQL_insertA);*/
                                        
                                        $validate .= '#kode_unik_tidak_valid ';
                                        $validate_score = 0;

                                        if (in_array($sub_from, $arr_prefix_indosat)){
                                            $output = urlencode($reply_kode_unik_salah).','.$tarif_konsumen;
                                            $output_save = $reply_kode_unik_salah;
                                        }
                                        else{
                                            $output = urlencode($reply_kode_unik_salah).',0';
                                            $output_save = $reply_kode_unik_salah;
                                        }

                                    }//if jml_cek == 0
                                    else if ($jml_cek_A > 0){
                                        if ($rowA['redeem_status'] == '0') {

                                            $now = date('Y-m-d');
                                            if ($rowA['date_from'] <= $now && $rowA['date_to'] >= $now) {//jika kode tidak kadaluarsa
                                                $SQL_update = "UPDATE ".$table." SET redeem_status='1', msisdn='{$from}', redeem_date=NOW() WHERE id='{$rowA['id']}' LIMIT 1";
                                                $conn->query($SQL_update);

                                                $validate .= '#kode_unik_valid ';
                                                $validate_score = 1;
                                                if (in_array($sub_from, $arr_prefix_indosat)){
                                                    $output = urlencode($reply_benar).','.$tarif_konsumen;
                                                    $output_save = $reply_benar;
                                                }
                                                else{
                                                    $output = urlencode($reply_benar).','.$tarif_konsumen;
                                                    $output_save = $reply_benar;
                                                }
                                            }else{
                                                $validate .= '#kode_unik_kadaluarsa ';
                                                $validate_score = 0;
                                                $output = urlencode($reply_kode_kadaluarsa).',0';
                                                $output_save = $reply_kode_kadaluarsa;
                                            }
                                        }
                                        else{
                                            $validate .= '#kode_unik_sudah_pernah_digunakan ';
                                            $validate_score = 0;
                                            if (in_array($sub_from, $arr_prefix_indosat)){
                                                $output = urlencode($reply_kode_unik_sdh_terpakai).','.$tarif_konsumen;
                                                $output_save = $reply_kode_unik_sdh_terpakai;
                                            }
                                            else{
                                                $output = urlencode($reply_kode_unik_sdh_terpakai).',0';
                                                $output_save = $reply_kode_unik_sdh_terpakai;
                                            }
                                        }//else redeem status
                                    }//
                                }else{// jika tidak sama panjang
                                    $validate .= '#kode_unik_tidak_valid ';
                                    $validate_score = 0;

                                    if (in_array($sub_from, $arr_prefix_indosat)){
                                        $output = urlencode($reply_kode_unik_salah).','.$tarif_konsumen;
                                        $output_save = $reply_kode_unik_salah;
                                    }
                                    else{
                                        $output = urlencode($reply_kode_unik_salah).',0';
                                        $output_save = $reply_kode_unik_salah;
                                    }
                                }
                            }// end jika data account store ada
                            else{// jika data account store tidak ada
                                $validate .= '#account_store_tidak_valid ';
                                $validate_score = 0;

                                if (in_array($sub_from, $arr_prefix_indosat)){
                                    $output = urlencode($reply_format_salah).','.$tarif_konsumen;
                                    $output_save = $reply_format_salah;
                                }
                                else{
                                    $output = urlencode($reply_format_salah).',0';
                                    $output_save = $reply_format_salah;
                                }
                            }// end jika data account store tidak ada
                        }elseif ($account_store == ACCOUNT_ALFAMART) {
                            // account store alfamart
                            $sqlCekAccount = "select id, name, length_kode_unik from account_store where lower(name)=lower('$account_store') limit 1";
                            $rsCekAccount  = $conn->query($sqlCekAccount)->fetch_assoc();

                            if (!empty($rsCekAccount)) {// jika data account store ada
                                // if panjang kode unik yang diinput sama dengan panjang kode unik alfamart
                                if (strlen($kode_unik) == $rsCekAccount['length_kode_unik']) {
                                    $sqlCekA    = "SELECT id, redeem_status FROM redeem_alfa WHERE LOWER(kode_unik)=LOWER('$kode_unik') LIMIT 1";
                                    $rsCekA     = $conn->query($sqlCekA);
                                    $jml_cek_A  = $rsCekA->num_rows;
                                    $rowA       = $rsCekA->fetch_assoc();

                                    if ($jml_cek_A ==  0) {// jika kode unik belum pernah digunakan
                                        // harus ada pengecekan apakah kode unik yg diinput sesuai dengan rumusan atau tidak

                                        if(cekRumusAlfamart($kode_unik)){
                                            $SQL_insertA = "INSERT INTO redeem_alfa (redeem_status, kode_unik, msisdn, redeem_date) VALUES ('1', '$kode_unik', '$from', NOW() )";
                                            $conn->query($SQL_insertA);

                                            $validate .= '#kode_unik_valid ';
                                            $validate_score = 1;
                                            if (in_array($sub_from, $arr_prefix_indosat)){
                                                $output = urlencode($reply_benar).','.$tarif_konsumen;
                                                $output_save = $reply_benar;
                                            }
                                            else{
                                                $output = urlencode($reply_benar).','.$tarif_konsumen;
                                                $output_save = $reply_benar;
                                            }
                                        }else{
                                            $validate .= '#kode_unik_tidak_valid ';
                                            $validate_score = 0;

                                            if (in_array($sub_from, $arr_prefix_indosat)){
                                                $output = urlencode($reply_kode_unik_salah).','.$tarif_konsumen;
                                                $output_save = $reply_kode_unik_salah;
                                            }
                                            else{
                                                $output = urlencode($reply_kode_unik_salah).',0';
                                                $output_save = $reply_kode_unik_salah;
                                            }
                                        }

                                    }// end jika kode unik belum pernah digunakan
                                    else if ($jml_cek_A > 0){// jika kode unik sudah pernah digunakan
                                        $validate .= '#kode_unik_sudah_pernah_digunakan ';
                                        $validate_score = 0;
                                        if (in_array($sub_from, $arr_prefix_indosat)){
                                            $output = urlencode($reply_kode_unik_sdh_terpakai).','.$tarif_konsumen;
                                            $output_save = $reply_kode_unik_sdh_terpakai;
                                        }
                                        else{
                                            $output = urlencode($reply_kode_unik_sdh_terpakai).',0';
                                            $output_save = $reply_kode_unik_sdh_terpakai;
                                        }
                                    }// end jika kode unik sudah pernah digunakan
                                }else{// jika tidak sama panjang
                                    $validate .= '#kode_unik_tidak_valid ';
                                    $validate_score = 0;

                                    if (in_array($sub_from, $arr_prefix_indosat)){
                                        $output = urlencode($reply_kode_unik_salah).','.$tarif_konsumen;
                                        $output_save = $reply_kode_unik_salah;
                                    }
                                    else{
                                        $output = urlencode($reply_kode_unik_salah).',0';
                                        $output_save = $reply_kode_unik_salah;
                                    }
                                }
                            }// end jika data account store ada
                            else{// jika data account store tidak ada
                                $validate .= '#account_store_tidak_valid ';
                                $validate_score = 0;

                                if (in_array($sub_from, $arr_prefix_indosat)){
                                    $output = urlencode($reply_format_salah).','.$tarif_konsumen;
                                    $output_save = $reply_format_salah;
                                }
                                else{
                                    $output = urlencode($reply_format_salah).',0';
                                    $output_save = $reply_format_salah;
                                }
                            }// end jika data account store tidak ada
                        }elseif ($account_store == ACCOUNT_ALFAMIDI) {
                            // account store alfamidi
                            $sqlCekAccount = "select id, name, length_kode_unik from account_store where lower(name)=lower('$account_store') limit 1";
                            $rsCekAccount  = $conn->query($sqlCekAccount)->fetch_assoc();

                            if (!empty($rsCekAccount)) {// jika data account store ada
                                // if panjang kode unik yang diinput sama dengan panjang kode unik alfamidi
                                if (strlen($kode_unik) == $rsCekAccount['length_kode_unik']) {
                                    $sqlCekA    = "SELECT id, redeem_status FROM redeem_alfa WHERE LOWER(kode_unik)=LOWER('$kode_unik') LIMIT 1";
                                    $rsCekA     = $conn->query($sqlCekA);
                                    $jml_cek_A  = $rsCekA->num_rows;
                                    $rowA       = $rsCekA->fetch_assoc();

                                    if ($jml_cek_A ==  0) {// jika kode unik belum pernah digunakan
                                        // harus ada pengecekan apakah kode unik yg diinput sesuai dengan rumusan atau tidak
                                        if(cekRumusAlfamart($kode_unik)){
                                            $SQL_insertA = "INSERT INTO redeem_alfa (redeem_status, kode_unik, msisdn, redeem_date) VALUES ('1', '$kode_unik', '$from', NOW() )";
                                            $conn->query($SQL_insertA);

                                            $validate .= '#kode_unik_valid ';
                                            $validate_score = 1;
                                            if (in_array($sub_from, $arr_prefix_indosat)){
                                                $output = urlencode($reply_benar).','.$tarif_konsumen;
                                                $output_save = $reply_benar;
                                            }
                                            else{
                                                $output = urlencode($reply_benar).','.$tarif_konsumen;
                                                $output_save = $reply_benar;
                                            }
                                        }else{
                                            $validate .= '#kode_unik_tidak_valid ';
                                            $validate_score = 0;

                                            if (in_array($sub_from, $arr_prefix_indosat)){
                                                $output = urlencode($reply_kode_unik_salah).','.$tarif_konsumen;
                                                $output_save = $reply_kode_unik_salah;
                                            }
                                            else{
                                                $output = urlencode($reply_kode_unik_salah).',0';
                                                $output_save = $reply_kode_unik_salah;
                                            }
                                        }

                                    }// end jika kode unik belum pernah digunakan
                                    else if ($jml_cek_A > 0){// jika kode unik sudah pernah digunakan
                                        $validate .= '#kode_unik_sudah_pernah_digunakan ';
                                        $validate_score = 0;
                                        if (in_array($sub_from, $arr_prefix_indosat)){
                                            $output = urlencode($reply_kode_unik_sdh_terpakai).','.$tarif_konsumen;
                                            $output_save = $reply_kode_unik_sdh_terpakai;
                                        }
                                        else{
                                            $output = urlencode($reply_kode_unik_sdh_terpakai).',0';
                                            $output_save = $reply_kode_unik_sdh_terpakai;
                                        }
                                    }// end jika kode unik sudah pernah digunakan
                                }else{// jika tidak sama panjang
                                    $validate .= '#kode_unik_tidak_valid ';
                                    $validate_score = 0;

                                    if (in_array($sub_from, $arr_prefix_indosat)){
                                        $output = urlencode($reply_kode_unik_salah).','.$tarif_konsumen;
                                        $output_save = $reply_kode_unik_salah;
                                    }
                                    else{
                                        $output = urlencode($reply_kode_unik_salah).',0';
                                        $output_save = $reply_kode_unik_salah;
                                    }
                                }
                            }// end jika data account store ada
                            else{// jika data account store tidak ada
                                $validate .= '#account_store_tidak_valid ';
                                $validate_score = 0;

                                if (in_array($sub_from, $arr_prefix_indosat)){
                                    $output = urlencode($reply_format_salah).','.$tarif_konsumen;
                                    $output_save = $reply_format_salah;
                                }
                                else{
                                    $output = urlencode($reply_format_salah).',0';
                                    $output_save = $reply_format_salah;
                                }
                            }// end jika data account store tidak ada
                        }else{
                            // account store salah
                            $validate .= '#account_store_tidak_valid ';
                            $validate_score = 0;

                            if (in_array($sub_from, $arr_prefix_indosat)){
                                $output = urlencode($reply_format_salah).','.$tarif_konsumen;
                                $output_save = $reply_format_salah;
                            }
                            else{
                                $output = urlencode($reply_format_salah).',0';
                                $output_save = $reply_format_salah;
                            }
                        }
                    }//end cek no hp dan no ktp
                    else{
                        // no hp dan no ktp salah
                        $validate .= '#no_hp_atau_ho_ktp_salah ';
                        $validate_score = 0;

                        if (in_array($sub_from, $arr_prefix_indosat)){
                            $output = urlencode($reply_format_salah).','.$tarif_konsumen;
                            $output_save = $reply_format_salah;
                        }
                        else{
                            $output = urlencode($reply_format_salah).',0';
                            $output_save = $reply_format_salah;
                        }
                    }
                }//end cek character hero
                else{
                    // character hero salah
                    $validate .= '#character_hero_salah ';
                    $validate_score = 0;

                    if (in_array($sub_from, $arr_prefix_indosat)){
                        $output = urlencode($reply_format_salah).','.$tarif_konsumen;
                        $output_save = $reply_format_salah;
                    }
                    else{
                        $output = urlencode($reply_format_salah).',0';
                        $output_save = $reply_format_salah;
                    }
                }

            }//end if tgl promo masih berlaku
            else{
                /* tanggal sudah lewat */
                $output = urlencode($reply_promo_abis).',0';
                $output_save = $reply_promo_abis;
            }//end else tgl promo habis
        }//end if $jml_hash
    }//endif exp == KATA_KUNCI_PROMO
    else{

        $output = urlencode($reply_format_salah).','.$tarif_konsumen;
        $output_save = $reply_format_salah;
    }

    //------- insert all sms to log
    if ($from != '') {

        $nama           = '';
        $kode_unik      = '';
        $no_hp          = '';
        $account_store  = '';
        $no_ktp         = '';
        $character      = '';
        $input_via      = '';
        $account_id     = 0;
        $character_id   = 0;

        if ($text != '') {
            $text               = urldecode( $text );
            $kata_kunci_promo   = strtolower(substr($text, 0, 6));
            $text_sms_cut       = substr($text, 7);
            $array_rep          = array(" #", "# ");
            $array_rep2         = array(' ', '-', 'à');
            $text_sms_cut       = str_replace($array_rep, "#", $text_sms_cut);
            $text_sms_cut       = str_replace("\n", "", $text_sms_cut);
            $parse_promo_text   = explode("#", $text_sms_cut);

            if(count($parse_promo_text) == 6){
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = ucwords(strtolower($parse_promo_text[0]));
                $kode_unik          = str_replace($array_rep2, '', $parse_promo_text[1]);
                $no_hp              = str_replace($array_rep2, '', $parse_promo_text[2]);// BELUM HANDLE DIGIT AWAL
                $account_store      = str_replace($array_rep2, '', ucwords(strtolower($parse_promo_text[3])));
                $no_ktp             = str_replace($array_rep2, '', $parse_promo_text[4]);
                $character          = str_replace($array_rep2, '', ucwords(strtolower($parse_promo_text[5])));
                $input_via          = VIA_SMS;
            }elseif(count($parse_promo_text) == 5){
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = ucwords(strtolower($parse_promo_text[0]));
                $kode_unik          = str_replace($array_rep2, '', $parse_promo_text[1]);
                $no_hp              = str_replace($array_rep2, '', $parse_promo_text[2]);// BELUM HANDLE DIGIT AWAL
                $account_store      = str_replace($array_rep2, '', ucwords(strtolower($parse_promo_text[3])));
                $no_ktp             = str_replace($array_rep2, '', $parse_promo_text[4]);
                $character          = '';
                $input_via          = VIA_SMS;
            }elseif(count($parse_promo_text) == 4){
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = ucwords(strtolower($parse_promo_text[0]));
                $kode_unik          = str_replace($array_rep2, '', $parse_promo_text[1]);
                $no_hp              = str_replace($array_rep2, '', $parse_promo_text[2]);// BELUM HANDLE DIGIT AWAL
                $account_store      = str_replace($array_rep2, '', ucwords(strtolower($parse_promo_text[3])));
                $no_ktp             = '';
                $character          = '';
                $input_via          = VIA_SMS;
            }elseif(count($parse_promo_text)==3){
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = ucwords(strtolower($parse_promo_text[0]));
                $kode_unik          = str_replace($array_rep2, '', $parse_promo_text[1]);
                $no_hp              = str_replace($array_rep2, '', $parse_promo_text[2]);// BELUM HANDLE DIGIT AWAL
                $account_store      = '';
                $no_ktp             = '';
                $character          = '';
                $input_via          = VIA_SMS;
            }elseif(count($parse_promo_text)==2) {
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = ucwords(strtolower($parse_promo_text[0]));
                $kode_unik          = str_replace($array_rep2, '', $parse_promo_text[1]);
                $no_hp              = '';
                $account_store      = '';
                $no_ktp             = '';
                $character          = '';
                $input_via          = VIA_SMS;
            }elseif(count($parse_promo_text)==1){
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = ucwords(strtolower($parse_promo_text[0]));
                $kode_unik          = '';
                $no_hp              = '';
                $account_store      = '';
                $no_ktp             = '';
                $character          = '';
                $input_via          = VIA_SMS;
            }else{
                $kata_kunci_promo   = ucwords($kata_kunci_promo);
                $nama               = '';
                $kode_unik          = '';
                $no_hp              = '';
                $account_store      = '';
                $no_ktp             = '';
                $character          = '';
                $input_via          = VIA_SMS;
            }

            if (!empty($no_hp)) {
                if (substr($no_hp, 0, 3) == "+62") {
                    $no_hp = "62" . substr($no_hp, 3);
                } elseif (substr($no_hp, 0, 2) == "62") {
                    $no_hp = "62" . substr($no_hp, 2);
                } elseif (substr($no_hp, 0, 1) == "0") {
                    $no_hp = "62" . substr($no_hp, 1);
                } else {
                    $no_hp = $no_hp;
                }
            }

            $sqlGetIdAccount = "select id, `name` from account_store where lower(`name`)=lower('$account_store') limit 1";
            $data_account = $conn->query($sqlGetIdAccount)->fetch_assoc();
            if (!empty($data_account)) {
                $data_account = $data_account;
                $account_id = $data_account['id'];
            }

            $sqlGetIdChar = "select id, `name` from `character` where lower(`name`)=lower('$character') limit 1";
            $data_char = $conn->query($sqlGetIdChar)->fetch_assoc();
            if (!empty($data_char)) {
                $data_char = $data_char;
                $character_id = $data_char['id'];
            }
        }
        else{

        }

        $sqlInsertLog = "INSERT INTO `data_input_kode_unik`(
                                                                `msisdn`,
                                                                `text`,
                                                                `reply`,
                                                                `time`,
                                                                `shortcode`,
                                                                `moid`,
                                                                `msgid`,
                                                                `telcoid`,
                                                                `validate`,
                                                                `validate_score`,
                                                                `kode_unik`,
                                                                `promo_key`,
                                                                `nama`,
                                                                `no_hp`,
                                                                `account_store`,
                                                                `no_ktp`,
                                                                `character`,
                                                                `account_id`,
                                                                `character_id`,
                                                                `input_via`,
                                                                `time_created`,
                                                                `time_updated`
                                                            )
                        VALUES (
                                    '$from',
                                    '$text',
                                    '$output_save',
                                    '$time',
                                    '$shortcode',
                                    '$moid',
                                    '$msgid',
                                    '$telcoid',
                                    '$validate',
                                    '$validate_score',
                                    '$kode_unik',
                                    '$kata_kunci_promo',
                                    '$nama',
                                    '$no_hp',
                                    '$account_store',
                                    '$no_ktp',
                                    '$character',
                                    '$account_id',
                                    '$character_id',
                                    '$input_via',
                                    now(),
                                    now()
                                )";

        $rsInsertLog=$conn->query($sqlInsertLog);
        if($rsInsertLog === false) {
            #trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        else {
            $rows_returned = $rsInsertLog;
        }
    }
    //------- insert all sms to log

    //------- final output
    if (in_array($sub_from, $arr_prefix_telkomsel)){
        if ( $output != '' ) {
            if (substr($output, -3) == '350') {
                $subOutput = substr($output, 0, -4);
            }else{
                $subOutput = substr($output, 0, -2);
            }
            $url = "http://10.18.8.111/send/sms111.php?user=nadyneapi&pwd=nadyneapi&sender=MIZONE&T&msisdn=".$from."&message=".$subOutput;
        }else{
            $url = "http://10.18.8.111/send/sms111.php?user=nadyneapi&pwd=nadyneapi&sender=MIZONE&T&msisdn=".$from."&message=".urlencode($reply_promo_abis);
        }
        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // grab URL and pass it to the browser
        $returnCURL = curl_exec($ch);

        // insert return to db
        $SQL_insertA = "INSERT INTO return_curl 
                        (`return`, msisdn, time_recive) 
                        VALUES 
                        ('{$returnCURL}', '{$from}', NOW() )";
        $conn->query($SQL_insertA);

        // close cURL resource, and free up system resources
        curl_close($ch);
    }else{
        if ( $output != '' ) {
            echo '0,'.$from.','.$output;
        }else{
            echo '0,'.$from.','.urlencode($reply_promo_abis).',0';
        }
    }


    
