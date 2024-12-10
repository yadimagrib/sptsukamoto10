<?php
error_reporting(~E_NOTICE);
session_start();

include 'config.php';
include 'includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/general.php';
include 'includes/fuzzy.php';

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

$db->query("DELETE FROM tb_himpunan WHERE kode_kriteria NOT IN (SELECT kode_kriteria FROM tb_kriteria)");

$rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif ORDER BY kode_alternatif");
foreach ($rows as $row) {
    $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
}

$rows = $db->get_results("SELECT * FROM tb_himpunan ORDER BY kode_himpunan");
$HIMPUNAN = array();
$KRITERIA_HIMPUNAN = array();
$ATRIBUT = array();
foreach ($rows as $row) {
    $HIMPUNAN[$row->kode_himpunan] = $row;
    $KRITERIA_HIMPUNAN[$row->kode_kriteria][$row->kode_himpunan] = $row;
}

$rows = $db->get_results("SELECT * FROM tb_kriteria ORDER BY kode_kriteria");
foreach ($rows as $row) {
    $ATRIBUT[$row->dicari][$row->kode_kriteria] = $row;
    $KRITERIA[$row->kode_kriteria] = $row;
    $target = $row->kode_kriteria;
}

function update_kriteria()
{
    global $db;
    $db->query("UPDATE tb_kriteria SET dicari=0");
    $db->query("UPDATE tb_kriteria SET dicari=1 ORDER BY kode_kriteria DESC LIMIT 1");
}
/** ============================== */

function get_aturan()
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_aturan ORDER BY no_aturan, kode_kriteria");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->no_aturan][$row->kode_kriteria] = $row;
    }

    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$key] = new Rule($val);
    }
    //echo '<pre>' . print_r($arr2, 1) . '</pre>';
    return $arr2;
}

function get_relasi()
{
    global $db;
    $data = array();
    $rows = $db->get_results("SELECT * 
        FROM tb_rel_alternatif r INNER JOIN tb_kriteria k ON k.kode_kriteria=r.kode_kriteria
        WHERE k.dicari=0
        ORDER BY kode_alternatif, r.kode_kriteria");
    foreach ($rows as $row) {
        $data[$row->kode_alternatif][$row->kode_kriteria] = $row->nilai;
    }
    return $data;
}

function get_hasil_option($selected)
{
    global $ATRIBUT, $KRITERIA_HIMPUNAN;
    reset($ATRIBUT);
    $dicari = current($ATRIBUT[1]);

    $a = '';
    foreach ($KRITERIA_HIMPUNAN[$dicari->kode_kriteria] as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val->nama_himpunan</option>";
        else
            $a .= "<option value='$key'>$val->nama_himpunan</option>";
    }
    return $a;
}

function get_himpunan_option($kode_kriteria, $selected)
{
    global $KRITERIA_HIMPUNAN;
    $a = '';
    foreach ($KRITERIA_HIMPUNAN[$kode_kriteria] as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val->nama_himpunan</option>";
        else
            $a .= "<option value='$key'>$val->nama_himpunan</option>";
    }
    return $a;
}

function get_operator_option($selected)
{
    $arr = array('AND' => 'AND', 'OR' => 'OR');
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val</option>";
        else
            $a .= "<option value='$key'>$val</option>";
    }
    return $a;
}

function get_dicari()
{
    global $KRITERIA;
    end($KRITERIA);
    $dicari = key($KRITERIA);
    reset($KRITERIA);
    return $dicari;
}
