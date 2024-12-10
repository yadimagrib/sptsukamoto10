<?php

function generate_aturan()
{
    global $KRITERIA_HIMPUNAN;
    end($KRITERIA_HIMPUNAN);
    $kode_target = key($KRITERIA_HIMPUNAN);

    $arr = $KRITERIA_HIMPUNAN;
    array_pop($arr);

    $a = 0;
    $aturan = array();
    foreach ($arr as $key => $val) {
        $aturan = _generate_aturan($aturan, $key, $val);
    }

    $val_target = $KRITERIA_HIMPUNAN[$kode_target];

    $fields = array();
    foreach ($aturan as $key => $val) {
        $val[$kode_target] = array_rand($val_target);
        foreach ($val as $k => $v) {
            $fields[] = array(
                'no_aturan' => $key + 1,
                'kode_kriteria' => $k,
                'kode_himpunan' => $v,
                'operator' => 'AND',
            );
        }
    }
    global $db;
    $db->multi_query('tb_aturan', $fields);
    //echo '<pre>' . print_r($aturan, 1) . '</pre>';
}
function _generate_aturan($aturan, $key, $val)
{
    if ($aturan) {
        $arr  = array();
        foreach ($aturan as $k => $v) {
            foreach ($val as $a => $b) {
                $v[$key] = $a;
                $arr[] = $v;
            }
        }
        //echo '<pre>' . print_r($arr, 1) . '</pre>';
        return $arr;
    }
    $arr  = array();
    foreach ($val as $k => $v) {
        $arr[] = array($key => $k);
    }
    //echo '<pre>' . print_r($arr, 1) . '</pre>';
    return $arr;
}
class Fuzzy
{
    /**
     * data nilai alternatif
     **/
    protected $data;
    /**
     * data aturan
     **/
    protected $rules;
    /**
     * nilai fuzzy
     **/
    protected $nilai;
    /**
     * nilai miu
     **/
    protected $miu;
    /**
     * nilai z
     **/
    protected $z;
    /**
     * hasil defuzzyfikasi
     **/
    protected $total;
    /**
     * hasil perangkingan
     **/
    protected $rank;

    /**
     * konstruktor
     * @param $rules int Basis aturan
     * @param $data  int Data nilai alternatif
     **/
    function __construct($rules, $data)
    {
        $this->rules = $rules;
        $this->data = $data;
    }
    /**
     * Melakukan proses perhitungan fuzzy
     **/
    function calculate()
    {
        $this->hitung_nilai();
        $this->hitung_miu();
        $this->hitung_z();
        $this->hitung_total();
        $this->hitung_rank();
    }
    /**
     * Mengambil data
     * @return   array   $data
     **/
    function get_data()
    {
        return $this->data;
    }
    /**
     * Menghitung nilai fuzzy masing-masing alternatif    
     **/
    function hitung_nilai()
    {
        global $KRITERIA_HIMPUNAN, $KRITERIA;

        $arr = array();
        //echo '<pre>' . print_r($this->data, 1) . '</pre>';                
        foreach ($this->data as $key => $val) { // mengulang sebanyak baris data
            foreach ($val as $k => $v) { //mengulang sebanyak kolom data
                foreach ($KRITERIA_HIMPUNAN[$k] as $a => $b) { //mengulang sebanyak himpunan fuzzy
                    $ba = $KRITERIA[$k]->batas_atas;
                    $bb = $KRITERIA[$k]->batas_bawah;

                    $n1 = $b->n1;
                    $n2 = $b->n2;
                    $n3 = $b->n3;
                    $n4 = $b->n4;

                    if ($v <= $n1) //jika di bawah trapesium
                        $nilai = 0;
                    else if ($v >= $n1 && $v <= $n2) //jika pada daerah trapesium naik
                        $nilai = ($v - $n1) / ($n2 - $n1);
                    else if ($v >= $n2 && $v <= $n3) //jika pada daerah trapesum atas
                        $nilai = 1;
                    else if ($v >= $n3 && $v <= $n4) //jika pada daerah trapesium turun
                        $nilai = ($n4 - $v) / ($n4 - $n3);
                    else //jika lebih dari trapesium
                        $nilai = 0;

                    if ($v >= $ba && ($n3 >= $ba || $n4 >= $ba)) //jika melebihi batas atas
                        $nilai = 1;

                    if ($v <= $bb && ($n1 <= $bb || $n2 <= $bb)) //jika melebihi batas bawah
                        $nilai = 1;

                    $arr[$key][$k][$a] = $nilai;
                }
            }
        }


        $this->nilai = $arr;
    }
    /**
     * Mengambil nilai fuzzy
     * @return   array Data nilai fuzzy
     **/
    function get_nilai()
    {
        return $this->nilai;
    }
    /**
     * Mengambil rules
     * @return   array Data rules
     **/
    function get_rules()
    {
        return $this->rules;
    }
    /**
     * Melakukan perhitungan miu    
     **/
    function hitung_miu()
    {
        $data = array();
        $arr = array();

        /**
         * Mengelompokkan nilai miu
         */
        foreach ($this->nilai as $key => $val) {
            foreach ($this->rules as $k => $v) {
                foreach ($v->input as $a => $b) {
                    $data[$k][$key][] = $val[$a][$b];
                }
            }
        }
        /**
         * Mencari nilai miu
         */
        foreach ($data as $key => $val) {
            foreach ($val as $k => $v) {
                //echo $this->rules[$key]->operator.'<br />';
                if ($this->rules[$key]->operator == 'AND') //jika operator AND maka dicari nilai terkecil
                    $arr[$key][$k] = min($v);
                else  //jika operator OR maka dicari nilai terbesar
                    $arr[$key][$k] = max($v);
            }
        }
        $this->miu = $arr;
    }
    /**
     * Mengambil nilai miu
     * @return   array Data nilai miu
     **/
    function get_miu()
    {
        return $this->miu;
    }
    /**
     * Mengambil nilai z    
     **/
    function hitung_z()
    {
        global $HIMPUNAN, $KRITERIA;

        foreach ($this->rules as $no_aturan => $rule) {
            $output = $rule->output;
            $kode_kriteria = key($output);
            $kode_himpunan = current($output);

            /**
             * Batas bawah dan batas atas
             */
            $ba = $KRITERIA[$kode_kriteria]->batas_atas;
            $bb = $KRITERIA[$kode_kriteria]->batas_bawah;

            /**
             * Titik-titik pada trapesium
             */
            $n1 = $HIMPUNAN[$kode_himpunan]->n1;
            $n2 = $HIMPUNAN[$kode_himpunan]->n2;
            $n3 = $HIMPUNAN[$kode_himpunan]->n3;
            $n4 = $HIMPUNAN[$kode_himpunan]->n4;

            //$a = ($z1 - $n1)/($n2-$n1);
            //$a*($n2-$n1) = $z-$n1;
            //$z1-$n1 = $a*($n2-$n1);
            //$z1 = $a*($n2-$n1) + $n1;

            //$a = ($n4-$z1)/($n4-$n3);
            //$a*($n4-$n3) = $n4-$z1;
            //$n4-$z1 = $a*($n4-$n3);
            //-$z1 = $a*($n4-$n3) - $n4;
            //$z1 = -$a*($n4-$n3) + $n4;

            /**
             * Mencari nilai z
             */
            foreach ($this->miu[$no_aturan] as $key => $val) {
                $z = array();

                /**
                 * Untuk yang trapesium naik
                 */
                $zi = $val * ($n2 - $n1) + $n1;
                if ($val == 1 || $zi > $bb)
                    $z[] = $zi;

                /**
                 * Mencari yang trapesium turun
                 */
                $zi = -$val * ($n4 - $n3) + $n4;
                if ($val == 1 || $zi < $ba)
                    $z[] = $zi;
                $this->z[$no_aturan][$key] = $z;
            }
        }
    }
    /**
     * Mengambil nilai z
     * @return   array Data nilai z
     **/
    function get_z()
    {
        return $this->z;
    }
    /**
     * Mengambil nilai total    
     **/
    function hitung_total()
    {
        $arr = array();
        foreach ($this->miu as $key => $val) {
            foreach ($val as $k => $v) {
                if ($v > 0) {
                    $z = $this->z[$key][$k];
                    $arr[$k][$key] = array(
                        'a' => $v,
                        'az' => $v * array_sum($z) / count($z), //total nilai z dibagi dengan jumlah nilai z
                    );
                }
            }
        }

        foreach ($arr as $key => $val) {
            $az = array_sum(array_column($val, 'az')); //mentotalkan nilai az
            $a = array_sum(array_column($val, 'a')); //mentotalkan nilai az       
            $this->total[$key] = $a ? $az / $a : 0; //total adalah az dibagi a
        }
        //echo '<pre>' . print_r($arr, 1) . '</pre>';
    }
    /**
     * Mengambil nilai total
     * @return   array Data nilai total
     **/
    function get_total()
    {
        return $this->total;
    }
    /**
     * Mengambil rank
     * @return   array Data rank
     **/
    function hitung_rank()
    {
        $data = $this->total;
        arsort($data); //mengurutkan data dari besar ke kecil dengan tetap mempertahankan key array
        $no = 1;
        $new = array();
        foreach ($data as $key => $val) {
            $new[$key] = $no++;
        }
        $this->rank = $new;
    }
    /**
     * Mengambil data rank        
     * @return  array
     */
    function get_rank()
    {
        return $this->rank;
    }
    /**
     * Mencari klasifikasi himpunan berdasarkan total nilai    
     * @param   int     $val Total nilai    
     * @return  array
     */
    function get_klasifikasi($val)
    {
        global $ATRIBUT, $KRITERIA_HIMPUNAN, $KRITERIA, $HIMPUNAN;

        $key = key($ATRIBUT[1]);

        $arr = array();
        foreach ($KRITERIA_HIMPUNAN[$key] as $a => $b) {
            $ba = $KRITERIA[$key]->batas_atas;
            $bb = $KRITERIA[$key]->batas_bawah;

            $n1 = $b->n1;
            $n2 = $b->n2;
            $n3 = $b->n3;
            $n4 = $b->n4;

            if ($val <= $n1)
                $nilai = 0;
            else if ($val >= $n1 && $val <= $n2)
                $nilai = ($val - $n1) / ($n2 - $n1);
            else if ($val >= $n2 && $val <= $n3)
                $nilai = 1;
            else if ($val >= $n3 && $val <= $n4)
                $nilai = ($n4 - $val) / ($n4 - $n3);
            else
                $nilai = 0;

            if ($val >= $ba && ($n3 >= $ba || $n4 >= $ba))
                $nilai = 1;

            if ($val <= $bb && ($n1 <= $bb || $n2 <= $bb))
                $nilai = 1;

            $arr[$a] = $nilai;
        }

        arsort($arr);

        //echo '<pre>' . print_r($val, 1) . '</pre>';        

        return $HIMPUNAN[key($arr)]->nama_himpunan;
    }
}

class Rule
{
    public $no_aturan;
    public $operator;
    public $input;
    public $output;

    function __construct($rows)
    {
        $dicari = get_dicari();
        foreach ($rows as $row) {
            $this->no_aturan = $row->no_aturan;
            $this->operator = $row->operator;

            if ($row->kode_kriteria == $dicari) {
                $this->output[$row->kode_kriteria] = $row->kode_himpunan;
            } else {
                $this->input[$row->kode_kriteria] = $row->kode_himpunan;
            }
        }
    }

    function to_string()
    {
        global $HIMPUNAN, $KRITERIA;
        $str = 'IF';
        $arr = array();
        foreach ($this->input as $key => $val) {
            $arr[] = '<code>' . $KRITERIA[$key]->nama_kriteria . '</code> = <code>' . $HIMPUNAN[$val]->nama_himpunan . '</code>';
        }
        $str .= ' ' . implode(' ' . $this->operator . ' ', $arr);
        $str .= ' THEN <code>' . $KRITERIA[key($this->output)]->nama_kriteria . '</code> = <code>' . $HIMPUNAN[current($this->output)]->nama_himpunan . '</code>';

        return $str;
    }
}
