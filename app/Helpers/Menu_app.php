<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Menu_app
{
    private static function set_menu($module_name = null, $title = null, $css_class = null, $target = null)
    {
        $structure = null;
        if ($module_name !== null || $module_name !== '') {
            if ($css_class === null) {
                $structure = "<li><a href='" . $module_name . "' " . $target . "><span class='sub-item'></span>" . $title . "</a></li>";
            } else {
                $structure = "<li class='" . $css_class . "'><a href='" . $module_name . "'><span class='sub-item'></span>" . $title . "</a></li>";
            }
        }

        return $structure;
    }
    private static function menu_single($module_name, $font, $title)
    {

        $structure = '<li class="nav-item">
        
							<a href="' . $module_name . '">
                            <i class="fas fa-list"></i> 
                                ' . $font . '
                            <p>' . $title . '</p>
                            
 							</a>
						</li>';
        return $structure;
    }
    private static function parent_dropdown($judul, $icon = null)
    {
        $structure = '';
        if ($icon === null) {
            $structure .= '<li class="nav-item">
            <a data-toggle="collapse" href="#tables">
                <i class="fas fa-list"></i>
                <p>' . $judul . '</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav nav-collapse">';
        } else {
            $structure .= '<li class="nav-item">
            <a data-toggle="collapse" href="#tables">
                <i class="fas fa-' . $icon . '"></i>
                <p>' . $judul . '</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav nav-collapse">';
        }
        return $structure;
    }
    public static function tutup_menu()
    {
        $structure = '</ul>
        </div>
    </li>';
        return $structure;
    }

    public static function list_menu()
    {
        $menu = '';
        $user_id = Auth::user()->id;
        $query = DB::table('users')
            ->select('users.id', 'users.username', 'tmlevel.level', 'tmlevel.id as level_id')
            ->join('tmlevel', 'users.tmlevel_id', '=', 'tmlevel.id')
            ->where('users.id', $user_id)
            ->get();
        foreach ($query as $ls) {
            switch ($ls->level_id) {
                case 1:
                    $menu .= '<li class="nav-item">
                    <a data-toggle="collapse" href="#retribusi">
                        <i class="fa fa-users"></i>
                        <p>Master Data </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="retribusi">
                        <ul class="nav nav-collapse">';
                    $menu .= self::set_menu(Url('master/guru'), 'Guru');
                    $menu .= self::set_menu(Url('master/siswa'), 'Siswa');
                    $menu .= self::set_menu(Url('master/pegawai'), 'Pegawai');
                    $menu .= self::set_menu(Url('master/mapel'), 'Mata Pelajaran');
                    $menu .= self::set_menu(Url('master/jadwal'), 'Jadwal');
                    $menu .= '
                      </ul>
                    </div>
                </li>';
                    $menu .= '<li class="nav-item">
                    <a data-toggle="collapse" href="#presensi">
                        <i class="fa fa-cubes"></i>
                        <p>Presensi </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="presensi">
                        <ul class="nav nav-collapse">';
                    $menu .= self::set_menu(Url('master/rekap_presensi'), 'Rekap Presensi');
                    $menu .= self::set_menu(Url('master/scan'), 'Presensi');
                    $menu .= '
                      </ul>
                    </div>
                </li>';
                    $menu .= '<li class="nav-item">
                <a data-toggle="collapse" href="#report">
                    <i class="fa fa-users"></i>
                    <p>Report Presensi </p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="report">
                    <ul class="nav nav-collapse">';
                    $menu .= self::set_menu(Url('master/laporan_presensi'), 'Laporan Presensi', );
                    $menu .= self::set_menu(Url('laporan/siswa'), 'Laporan Siswa');
                    $menu .= '
                  </ul>
                </div>
                
            </li>';
                    break;
                case 2:
                    $menu .= '<li class="nav-item">
                            <ul class="nav">
                    ';
                    $menu .= self::menu_single(Url('master/jadwal'), '', 'Jadwal');
                    $menu .= self::menu_single(Url('master/rekap_presensi'), '', 'Rekap Presensi');
                    $menu .= self::menu_single(Url('master/laporan_presensi'),'', 'Laporan Presensi');
                    $menu .= self::menu_single(Url('master/scan'), '', 'Presensi');
                    '</ul>
                    </li>
                    ';
                    break;
                default:
                    $menu .= '<li>Null Route Menu</li>';

                    break;
            }
        }
        return $menu;
    }
}
