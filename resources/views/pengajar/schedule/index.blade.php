@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Kelola Jadwal Mengajar')

@section('content')
<div class="space-y-8 animate-fade-in" x-data="{ 
    editModalOpen: false, 
    editSchedule: { id: null, course_id: null, course_title: '', day_of_week: '', start_time: '', end_time: '', location: '' },
    deleteModalOpen: false,
    deleteActionUrl: '',
    deleteScheduleTitle: ''
}">
    <div>
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-wide font-sans">Jadwal Kelas Anda</h2>
        <p class="text-xs text-slate-500 dark:text-gray-400">Atur dan kelola jam sesi kelas, link Zoom, atau lokasi ruang belajar fisik untuk kursus Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Schedules List -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Jadwal Aktif Anda</h3>
            
            @if($schedules->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400">
                    <p class="text-sm">Anda belum menambahkan jadwal mengajar untuk kelas mana pun saat ini.</p>
                </div>
            @else
                @php
                    $daysOrder = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                    $groupedSchedules = $schedules->groupBy('day_of_week');
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($daysOrder as $englishDay => $indonesianDay)
                        @if(isset($groupedSchedules[$englishDay]))
                            <div class="glass-card rounded-2xl p-5 space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-100 dark:border-white/5 pb-2">
                                    <span class="text-sm font-bold text-slate-800 dark:text-white tracking-wide">{{ $indonesianDay }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-brand-cyan/10 text-brand-cyan font-semibold">
                                        {{ count($groupedSchedules[$englishDay]) }} Sesi
                                    </span>
                                </div>
                                
                                <div class="space-y-4">
                                    @foreach($groupedSchedules[$englishDay] as $schedule)
                                        <div class="p-3.5 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/2 space-y-2 hover:border-brand-purple/20 transition duration-200">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="space-y-0.5 min-w-0">
                                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ $schedule->course->title }}</h4>
                                                    <span class="text-[9px] text-slate-500 dark:text-gray-400 font-semibold uppercase tracking-wider">{{ $schedule->course->category }}</span>
                                                </div>
                                                
                                                <div class="flex items-center gap-1.5 shrink-0">
                                                    <!-- Edit Button -->
                                                    <button type="button" 
                                                            @click="editSchedule = { id: {{ $schedule->id }}, course_id: {{ $schedule->course_id }}, course_title: {{ json_encode($schedule->course->title) }}, day_of_week: '{{ $schedule->day_of_week }}', start_time: '{{ substr($schedule->start_time, 0, 5) }}', end_time: '{{ substr($schedule->end_time, 0, 5) }}', location: {{ json_encode($schedule->location) }} }; editModalOpen = true"
                                                            class="p-1.5 rounded bg-brand-cyan/5 hover:bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan transition cursor-pointer"
                                                            title="Edit Jadwal">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button type="button" 
                                                            @click="deleteScheduleTitle = {{ json_encode($schedule->course->title) }}; deleteActionUrl = '{{ route('pengajar.schedules.destroy', $schedule->id) }}'; deleteModalOpen = true"
                                                            class="p-1.5 rounded bg-red-500/5 hover:bg-red-500/10 border border-red-500/20 text-red-500 dark:text-red-400 transition cursor-pointer"
                                                            title="Hapus Jadwal">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="space-y-1 text-[11px] text-slate-500 dark:text-gray-400 border-t border-slate-100 dark:border-white/5 pt-2">
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-brand-cyan shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</span>
                                                </div>
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-brand-cyan shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    @if(str_contains(strtolower($schedule->location), 'http://') || str_contains(strtolower($schedule->location), 'https://'))
                                                        <a href="{{ $schedule->location }}" target="_blank" class="text-brand-cyan hover:underline truncate">{{ $schedule->location }}</a>
                                                    @else
                                                        <span class="truncate text-slate-700 dark:text-gray-300">{{ $schedule->location }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Add Schedule Form -->
        <div class="lg:col-span-1 space-y-6">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Tambah Jadwal Baru</h3>
            
            <div class="glass-card rounded-2xl p-5 space-y-4">
                @if($courses->isEmpty())
                    <p class="text-xs text-slate-500 dark:text-gray-400 text-center">Anda harus membuat kursus terlebih dahulu sebelum dapat mengatur jadwal kelas mengajar.</p>
                @else
                    <form action="" method="POST" id="schedule-form" class="space-y-4">
                        @csrf
                        
                        <div class="space-y-1">
                            <label for="course_select" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Pilih Kursus</label>
                            <select id="course_select" required onchange="updateFormAction(this.value)"
                                    class="w-full bg-white dark:bg-[#121217] border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                                <option value="">-- Pilih Kursus --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="day_select" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Hari</label>
                            <select name="day_of_week" id="day_select" required
                                    class="w-full bg-white dark:bg-[#121217] border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                                <option value="Monday">Senin</option>
                                <option value="Tuesday">Selasa</option>
                                <option value="Wednesday">Rabu</option>
                                <option value="Thursday">Kamis</option>
                                <option value="Friday">Jumat</option>
                                <option value="Saturday">Sabtu</option>
                                <option value="Sunday">Minggu</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label for="start_time" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Waktu Mulai</label>
                                <input type="time" name="start_time" id="start_time" required
                                       class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                            </div>
                            <div class="space-y-1">
                                <label for="end_time" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Waktu Selesai</label>
                                <input type="time" name="end_time" id="end_time" required
                                       class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="location" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Lokasi / Link Zoom</label>
                            <input type="text" name="location" id="location" required
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white placeholder-gray-450 dark:placeholder-gray-500 transition-all"
                                   placeholder="Contoh: Ruang Lab 01 atau link zoom.us/j/...">
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-115">
                            Simpan Jadwal Mengajar
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>
    <!-- Custom Edit Schedule Modal -->
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="editModalOpen" x-transition x-cloak style="display: none;">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-slate-200 dark:border-white/5" @click.away="editModalOpen = false">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/5 pb-3">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider font-sans">Edit Jadwal Sesi</h3>
                <button type="button" @click="editModalOpen = false" class="text-slate-500 hover:text-slate-800 dark:hover:text-white font-bold text-lg focus:outline-none cursor-pointer">&times;</button>
            </div>
            
            <form :action="'{{ url('pengajar/schedules') }}/' + editSchedule.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="space-y-1">
                    <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Kursus</label>
                    <input type="text" x-model="editSchedule.course_title" disabled
                           class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-500 dark:text-gray-400 focus:outline-none opacity-70">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Hari</label>
                    <select name="day_of_week" x-model="editSchedule.day_of_week" required
                            class="w-full bg-white dark:bg-[#121217] border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Waktu Mulai</label>
                        <input type="time" name="start_time" x-model="editSchedule.start_time" required
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Waktu Selesai</label>
                        <input type="time" name="end_time" x-model="editSchedule.end_time" required
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Lokasi / Link Zoom</label>
                    <input type="text" name="location" x-model="editSchedule.location" required
                           class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white transition-all">
                </div>

                <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-110 cursor-pointer">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- Custom Delete Schedule Confirmation Modal -->
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="deleteModalOpen" x-transition x-cloak style="display: none;">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="deleteModalOpen = false">
            <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider font-sans">Hapus Jadwal Sesi?</h3>
            </div>
            
            <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                <p>Apakah Anda yakin ingin menghapus jadwal sesi untuk kelas <strong class="text-slate-850 dark:text-white" x-text="deleteScheduleTitle"></strong>?</p>
                <p>Jadwal ini tidak akan ditampilkan lagi pada kalender agenda siswa.</p>
            </div>

            <form :action="deleteActionUrl" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="deleteModalOpen = false"
                            class="flex-1 py-2 rounded-lg border border-slate-200 dark:border-white/5 text-xs font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-lg shadow-red-500/20 transition cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateFormAction(courseId) {
        var form = document.getElementById('schedule-form');
        if (courseId) {
            form.action = "{{ url('pengajar/courses') }}/" + courseId + "/schedules";
        } else {
            form.action = "";
        }
    }
</script>
@endsection
