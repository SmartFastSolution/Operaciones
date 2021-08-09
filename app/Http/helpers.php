<?php

use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;



/**
 * Cambiar Formato Fechas
 *
 * @param mixed $date
 * @param mixed $date_format
 * @return string
 */

/**
 *Formatos Disponibles
 * @param 'Y-m-d'
 * @param 'Y-M-D'
 */
if (!function_exists('changeDateFormate')) {
    function changeDateFormate($date, $date_format)
    {
        return Carbon::parse($date)->format($date_format);
    }
}

if (!function_exists('diferenciaHumana')) {
    function diferenciaHumana($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
}
/**
 * Obtener Primer Dia Mes
 *
 * @param string $format
 * @return string
 */

if (!function_exists('starMonth')) {
    function starMonth($format = 'Y-m-d')
    {
        $s = Carbon::now()->startOfMonth();

        return $s->format($format);
    }
}
if (!function_exists('active')) {
    function active($url)
    {
        return  Request::is($url) ? ' active' : '';
    }
}
if (!function_exists('submenu')) {
    function submenu($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return ' recent-submenu mini-recent-submenu show';
            }
        }
    }
}
if (!function_exists('getRole')) {
    function getRole()
    {
        return  auth()->user()->roles[0]->name;
    }
}
if (!function_exists('findRole')) {
    function findRole(User $user)
    {
        return  $user->roles[0]->name;
    }
}
if (!function_exists('activeAll')) {
    function activeAll($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return ' active';
            }
        }
    }
}
if (!function_exists('expanded')) {
    function expanded($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return 'true';
            } else {
                $data = 'false';
            }
        }
    }
}
if (!function_exists('showAll')) {
    function showAll($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return ' show';
            }
        }
    }
}
if (!function_exists('expanded')) {
    function expanded($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return 'true';
            } else {
                $data = 'false';
            }
        }
    }
}
if (!function_exists('statusPostulante')) {
    function statusPostulante($estado)
    {
        if ($estado == 'postulado') {
            return 'badge-warning';
        } elseif ($estado == 'rechazado') {
            return 'badge-danger';
        }
    }
}
if (!function_exists('getFechaContrato')) {
    function getFechaContrato($json, $tipo)
    {
        $fechas = json_decode($json);
        if ($tipo == 'inicio') {
            return $fechas->fecha_contrato;
        } elseif ($tipo == 'final') {
            return $fechas->fecha_finalizacion;
        }
    }
}
if (!function_exists('outlineBadge')) {
    function outlineBadge()
    {
        $badges = collect(['outline-badge-danger', 'outline-badge-success', 'outline-badge-primary', 'outline-badge-warning', 'outline-badge-info']);
        return $badges->random();
    }
}
if (!function_exists('randomBadge')) {
    function randomBadge()
    {
        $badges = collect(['badge-danger', 'badge-success', 'badge-primary', 'badge-warning', 'badge-info']);
        return $badges->random();
    }
}
// if (!function_exists('getNotify')) {
//     function getNotify($tipo)
//     {
//         if ($tipo == 'solicitudes') {
//             $conteo = Auth::user()->solicitudes->where('estado', 'pendiente')->count();
//             return $conteo >= 1 ? "<small class='badge badge-danger'> {$conteo}</small>" : '';
//         } elseif ($tipo == 'postulaciones') {
//             $conteo = Auth::user()->postulantes->where('status', 'postulado')->count();
//             return $conteo >= 1 ? "<small class='badge badge-danger'> {$conteo}</small>" : '';
//         }
//     }
// }
