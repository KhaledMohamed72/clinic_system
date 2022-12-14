<?php

namespace App\Repository;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\DoctorRepositoryInterface;
use App\Repository\Interfaces\HomeRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeRepository extends Controller implements HomeRepositoryInterface
{
    public function showHome()
    {
        $appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->count();
        $today_appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('date', '=', Carbon::today()->toDateString())
            ->count();
        $tomorrow_appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('date', '=', Carbon::tomorrow()->toDateString())
            ->where('appointments.status', '=', 'pending')
            ->count();
        $upcomming_appointments_count = DB::table('appointments')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('date', '>', Carbon::today()->toDateString())
            ->where('appointments.status', '=', 'pending')
            ->count();
        $today_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->sum('fees');
        $today_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->sum('amount');
        $today_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->sum('fees');
        $today_earrings = $today_prescriptions_sum + $today_incomes_sum + $today_sessions_sum;
        $total_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->sum('fees');
        $total_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->sum('amount');
        $total_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->sum('fees');
        $revenue = $total_prescriptions_sum + $total_incomes_sum + $total_sessions_sum;
        $appointments = DB::table('appointments')
            ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
            ->join('users as t3', 't3.id', '=', 'appointments.doctor_id')
            ->where('appointments.clinic_id', '=', $this->getClinic()->id)
            ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
            ->select('appointments.*', 't2.name as patient_name', 't2.phone','t3.name as doctor_name')
            ->orderBy('appointments.date', 'desc')->get();

        $prescriptions = DB::table('prescriptions')
            ->join('users as t2', 't2.id', '=', 'prescriptions.patient_id')
            ->join('users as t3', 't3.id', '=', 'prescriptions.doctor_id')
            ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
            ->select('prescriptions.*', 't2.name as patient_name','t3.name as doctor_name')
            ->orderBy('prescriptions.created_at', 'desc')
            ->get();
        $current_month_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->sum('fees');
        $current_month_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->sum('amount');
        $current_month_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereMonth('created_at', '=', Carbon::now()->format('m'))
            ->sum('fees');
        $current_monthly_earrings = $current_month_prescriptions_sum + $current_month_incomes_sum + $current_month_sessions_sum;
        $last_month = (Carbon::now()->format('m') - 1) == 0 ? 12 : (Carbon::now()->format('m') - 1);
        $last_month_prescriptions_sum = DB::table('prescriptions')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereMonth('created_at', '=', $last_month)
            ->sum('fees');
        $last_month_incomes_sum = DB::table('incomes')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereMonth('created_at', '=', $last_month)
            ->sum('amount');
        $last_month_sessions_sum = DB::table('sessions_info')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->whereMonth('created_at', '=', $last_month)
            ->sum('fees');
        $last_monthly_earrings = $last_month_prescriptions_sum + $last_month_incomes_sum + $last_month_sessions_sum;
        $earring_percentage = $last_monthly_earrings != 0 ? (($current_monthly_earrings - $last_monthly_earrings) /  $last_monthly_earrings)* 100 : 100;
        $monthly_patients_counts = DB::table('patients')
            ->where('clinic_id',$this->getClinic()->id)
            ->selectRaw('month(created_at) as month')
            ->selectRaw('count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();
        $monthly_prescriptions_counts = DB::table('prescriptions')
            ->where('clinic_id',$this->getClinic()->id)
            ->selectRaw('month(created_at) as month')
            ->selectRaw('count(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();
        return [
            $appointments_count,
            $today_appointments_count,
            $tomorrow_appointments_count,
            $upcomming_appointments_count,
            $today_earrings,
            $revenue,
            $appointments,
            $prescriptions,
            $current_monthly_earrings,
            $last_monthly_earrings,
            $earring_percentage,
            $monthly_patients_counts,
            $monthly_prescriptions_counts
        ];
    }
}
