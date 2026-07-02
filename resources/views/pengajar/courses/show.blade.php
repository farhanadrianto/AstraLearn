@extends('layouts.app')

@section('title', 'Kelola Kursus: ' . $course->title)
@section('page-title', 'Detail & Manajemen Kelas')

@section('content')
<div class="space-y-8 animate-fade-in" x-data="{ tab: 'materi', deleteModalOpen: false, deleteConfirmText: '' }">
    <!-- Back to Course Index -->
    <a href="{{ route('pengajar.courses.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white transition duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Katalog Kursus</span>
    </a>

    <!-- Course Banner Details -->
    <div class="glass-card rounded-2xl p-6 md:p-8 flex flex-col md:flex-row gap-6 justify-between items-start md:items-center relative overflow-hidden">
        <div class="space-y-3 relative z-10">
            <span class="text-[10px] uppercase font-extrabold tracking-wider text-brand-cyan bg-brand-cyan/10 px-2.5 py-1 rounded-full">
                {{ $course->category }}
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">{{ $course->title }}</h2>
            <p class="text-slate-500 dark:text-gray-400 text-sm max-w-xl">{{ $course->description }}</p>
        </div>


    </div>

    <!-- Navigation Tabs -->
    <div class="flex border-b border-slate-200 dark:border-white/5 gap-2 select-none">
        <button class="px-6 py-3.5 font-bold text-sm tracking-wide border-b-2 transition duration-200 focus:outline-none"
                :class="tab === 'materi' ? 'border-brand-purple text-slate-900 dark:text-white bg-slate-50 dark:bg-white/[0.02]' : 'border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white'"
                @click="tab = 'materi'">
            📘 Kelola Materi ({{ $course->materials->count() }})
        </button>
        <button class="px-6 py-3.5 font-bold text-sm tracking-wide border-b-2 transition duration-200 focus:outline-none"
                :class="tab === 'tugas' ? 'border-brand-purple text-slate-900 dark:text-white bg-slate-50 dark:bg-white/[0.02]' : 'border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white'"
                @click="tab = 'tugas'">
            📝 Kelola Tugas ({{ $course->assignments->count() }})
        </button>
        <button class="px-6 py-3.5 font-bold text-sm tracking-wide border-b-2 transition duration-200 focus:outline-none"
                :class="tab === 'siswa' ? 'border-brand-purple text-slate-900 dark:text-white bg-slate-50 dark:bg-white/[0.02]' : 'border-transparent text-slate-500 dark:text-gray-400 hover:text-slate-800 dark:hover:text-white'"
                @click="tab = 'siswa'">
            🎓 Siswa Terdaftar ({{ $course->students->count() }})
        </button>
    </div>

    <!-- Tab Contents -->
    <div>
        <!-- TAB KELOLA MATERI -->
        <div x-show="tab === 'materi'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start" x-data="{ editMaterialModalOpen: false, editMaterial: { id: null, title: '', video_url: '', content: '' }, deleteMaterialModalOpen: false, deleteMaterialActionUrl: '', deleteMaterialTitle: '' }">
            
            <!-- Materials List -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Materi Terdaftar</h3>
                
                @if($course->materials->isEmpty())
                    <div class="glass-card rounded-2xl p-8 text-center text-slate-500 dark:text-gray-400">
                        <p class="text-xs">Belum ada materi pembelajaran yang ditambahkan.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($course->materials as $index => $material)
                            <div class="glass-card rounded-xl p-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 flex items-center justify-center font-bold text-xs text-slate-500 dark:text-gray-400 shrink-0">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ $material->title }}</h4>
                                        <div class="flex items-center gap-2 text-[10px] text-slate-500 dark:text-gray-400">
                                            @if($material->video_url)
                                                <span>🎥 Video</span>
                                            @endif
                                            @if($material->file_path)
                                                <span>&bull; 📄 PDF</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            @click="editMaterial = { id: {{ $material->id }}, title: {{ json_encode($material->title) }}, video_url: {{ json_encode($material->video_url) }}, content: {{ json_encode($material->content) }} }; editMaterialModalOpen = true"
                                            class="p-2 rounded-lg border border-brand-cyan/20 dark:border-brand-cyan/30 hover:border-brand-cyan bg-brand-cyan/5 hover:bg-brand-cyan/10 text-brand-cyan transition cursor-pointer"
                                            title="Edit Materi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="deleteMaterialTitle = {{ json_encode($material->title) }}; deleteMaterialActionUrl = '{{ route('pengajar.materials.destroy', $material->id) }}'; deleteMaterialModalOpen = true"
                                            class="p-2 rounded-lg border border-red-500/10 hover:border-red-500/30 bg-red-500/5 hover:bg-red-500/20 text-red-500 dark:text-red-400 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Add Material Form -->
            <div class="lg:col-span-1 glass-card rounded-2xl p-5 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-white/5">+ Tambah Materi</h3>
                
                <form action="{{ route('pengajar.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1">
                        <label for="material_title" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Judul Materi</label>
                        <input type="text" name="title" id="material_title" required
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white placeholder-gray-450 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"
                               placeholder="Contoh: Pengenalan Routing Laravel">
                    </div>

                    <div class="space-y-1">
                        <label for="material_video" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">URL Video Youtube (Opsional)</label>
                        <input type="url" name="video_url" id="material_video"
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white placeholder-gray-450 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"
                               placeholder="https://youtube.com/watch?v=...">
                    </div>

                    <div class="space-y-1">
                        <label for="material_file" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Unggah Modul / PDF (Opsional)</label>
                        <input type="file" name="file" id="material_file" accept=".pdf"
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none">
                    </div>

                    <div class="space-y-1">
                        <label for="material_content" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Isi Materi</label>
                        <textarea name="content" id="material_content" rows="6" required
                                  class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white placeholder-gray-450 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"
                                  placeholder="Tulis materi pembelajaran di sini..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-115">
                        Simpan Materi
                    </button>
                </form>
            </div>

            <!-- Edit Material Modal Overlay -->
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="editMaterialModalOpen" x-transition x-cloak style="display: none;">
                <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative" @click.away="editMaterialModalOpen = false">
                    <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/5 pb-3">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Edit Materi</h3>
                        <button type="button" @click="editMaterialModalOpen = false" class="text-slate-500 hover:text-slate-800 dark:hover:text-white font-bold text-lg focus:outline-none">&times;</button>
                    </div>
                    
                    <form :action="'{{ url('pengajar/materials') }}/' + editMaterial.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Judul Materi</label>
                            <input type="text" name="title" x-model="editMaterial.title" required
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                        </div>
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">URL Video Youtube (Opsional)</label>
                            <input type="url" name="video_url" x-model="editMaterial.video_url"
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Unggah Modul / PDF Baru (Opsional)</label>
                            <input type="file" name="file" accept=".pdf"
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none">
                            <p class="text-[9px] text-slate-400 dark:text-gray-500">Kosongkan jika tidak ingin mengubah file PDF sebelumnya.</p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Isi Materi</label>
                            <textarea name="content" x-model="editMaterial.content" rows="6" required
                                      class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"></textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-110">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Custom Delete Material Confirmation Modal -->
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="deleteMaterialModalOpen" x-transition x-cloak style="display: none;">
                <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="deleteMaterialModalOpen = false">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider font-sans">Hapus Materi Ini?</h3>
                    </div>
                    
                    <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                        <p>Apakah Anda yakin ingin menghapus materi pembelajaran <strong class="text-slate-850 dark:text-white" x-text="deleteMaterialTitle"></strong> secara permanen?</p>
                        <p>Modul PDF dan data pendukung lainnya yang terikat dengan materi ini akan ikut terhapus.</p>
                    </div>

                    <form :action="deleteMaterialActionUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="deleteMaterialModalOpen = false"
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

        <!-- TAB KELOLA TUGAS -->
        <div x-show="tab === 'tugas'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start" x-data="{ editAssignmentModalOpen: false, editAssignment: { id: null, title: '', points: 100, due_date: '', description: '' }, deleteAssignmentModalOpen: false, deleteAssignmentActionUrl: '', deleteAssignmentTitle: '' }">
            
            <!-- Assignments List -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Tugas Dirilis</h3>
                
                @if($course->assignments->isEmpty())
                    <div class="glass-card rounded-2xl p-8 text-center text-slate-500 dark:text-gray-400">
                        <p class="text-xs">Belum ada tugas untuk kursus ini.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($course->assignments as $assignment)
                            <div class="glass-card rounded-xl p-4 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ $assignment->title }}</h4>
                                    <div class="flex items-center gap-3 text-[10px] text-slate-500 dark:text-gray-400">
                                        <span>Batas: <strong class="text-slate-700 dark:text-gray-300">{{ $assignment->due_date->format('d M Y, H:i') }}</strong></span>
                                        <span>&bull;</span>
                                        <span>Poin: <strong class="text-brand-purple">{{ $assignment->points }}</strong></span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            @click="editAssignment = { id: {{ $assignment->id }}, title: {{ json_encode($assignment->title) }}, points: {{ $assignment->points }}, due_date: '{{ $assignment->due_date->format('Y-m-d\TH:i') }}', description: {{ json_encode($assignment->description) }} }; editAssignmentModalOpen = true"
                                            class="p-2 rounded-lg border border-brand-cyan/20 dark:border-brand-cyan/30 hover:border-brand-cyan bg-brand-cyan/5 hover:bg-brand-cyan/10 text-brand-cyan transition cursor-pointer"
                                            title="Edit Tugas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="deleteAssignmentTitle = {{ json_encode($assignment->title) }}; deleteAssignmentActionUrl = '{{ route('pengajar.assignments.destroy', $assignment->id) }}'; deleteAssignmentModalOpen = true"
                                            class="p-2 rounded-lg border border-red-500/10 hover:border-red-500/30 bg-red-500/5 hover:bg-red-500/20 text-red-500 dark:text-red-400 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Add Assignment Form -->
            <div class="lg:col-span-1 glass-card rounded-2xl p-5 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-white/5">+ Tambah Tugas Baru</h3>
                
                <form action="{{ route('pengajar.assignments.store', $course->id) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1">
                        <label for="assignment_title" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Judul Tugas</label>
                        <input type="text" name="title" id="assignment_title" required
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white placeholder-gray-450 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"
                               placeholder="Contoh: Membuat CRUD dengan Relasi">
                    </div>

                    <div class="space-y-1">
                        <label for="assignment_points" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Poin Maksimal</label>
                        <input type="number" name="points" id="assignment_points" min="1" max="1000" value="100" required
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                    </div>

                    <div class="space-y-1">
                        <label for="assignment_due" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Batas Pengumpulan (Deadline)</label>
                        <input type="datetime-local" name="due_date" id="assignment_due" required
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                    </div>

                    <div class="space-y-1">
                        <label for="assignment_desc" class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Petunjuk Pengerjaan Tugas</label>
                        <textarea name="description" id="assignment_desc" rows="5" required
                                  class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white placeholder-gray-450 dark:placeholder-gray-500 focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"
                                  placeholder="Jelaskan kebutuhan tugas, link repo GitHub, dll..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-115">
                        Rilis Tugas Baru
                    </button>
                </form>
            </div>

            <!-- Edit Assignment Modal Overlay -->
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="editAssignmentModalOpen" x-transition x-cloak style="display: none;">
                <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative" @click.away="editAssignmentModalOpen = false">
                    <div class="flex justify-between items-center border-b border-slate-200 dark:border-white/5 pb-3">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Edit Tugas</h3>
                        <button type="button" @click="editAssignmentModalOpen = false" class="text-slate-500 hover:text-slate-800 dark:hover:text-white font-bold text-lg focus:outline-none">&times;</button>
                    </div>
                    
                    <form :action="'{{ url('pengajar/assignments') }}/' + editAssignment.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Judul Tugas</label>
                            <input type="text" name="title" x-model="editAssignment.title" required
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                        </div>
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Poin Maksimal</label>
                            <input type="number" name="points" x-model="editAssignment.points" min="1" max="1000" required
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Batas Pengumpulan (Deadline)</label>
                            <input type="datetime-local" name="due_date" x-model="editAssignment.due_date" required
                                   class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-semibold text-slate-500 dark:text-gray-400 uppercase block">Petunjuk Pengerjaan Tugas</label>
                            <textarea name="description" x-model="editAssignment.description" rows="5" required
                                      class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand-purple/50 focus:ring-1 focus:ring-brand-purple/20 transition-all"></textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-brand text-white text-xs font-bold shadow-lg shadow-brand-purple/20 transition hover:brightness-110">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Custom Delete Assignment Confirmation Modal -->
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="deleteAssignmentModalOpen" x-transition x-cloak style="display: none;">
                <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="deleteAssignmentModalOpen = false">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider font-sans">Hapus Tugas Ini?</h3>
                    </div>
                    
                    <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                        <p>Apakah Anda yakin ingin menghapus tugas <strong class="text-slate-850 dark:text-white" x-text="deleteAssignmentTitle"></strong>?</p>
                        <p class="text-red-500 dark:text-red-400 font-semibold">Seluruh berkas pengumpulan dan nilai yang sudah dikumpulkan oleh siswa pada tugas ini akan terhapus secara permanen!</p>
                    </div>

                    <form :action="deleteAssignmentActionUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="deleteAssignmentModalOpen = false"
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

        <!-- TAB SISWA TERDAFTAR -->
        <div x-show="tab === 'siswa'" class="space-y-4" x-data="{ kickModalOpen: false, kickStudentName: '', kickStudentEmail: '', kickStudentActionUrl: '', kickConfirmText: '' }">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Siswa Terdaftar pada Kelas Ini</h3>
            
            @if($course->students->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center text-slate-500 dark:text-gray-400">
                    <p class="text-xs">Belum ada siswa yang mendaftar pada kursus ini.</p>
                </div>
            @else
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 bg-[#121217]/5 dark:bg-[#121217]/20">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-white/5 bg-slate-100 dark:bg-white/2 text-slate-600 dark:text-gray-400 font-semibold uppercase tracking-wider">
                                <th class="p-4">Nama Siswa</th>
                                <th class="p-4">Alamat Email</th>
                                <th class="p-4">Progres Kursus</th>
                                <th class="p-4">Progres Tugas</th>
                                <th class="p-4">Tanggal Bergabung</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($course->students as $student)
                                @php
                                    $studentId = $student->id;
                                    $courseAssignmentIds = $course->assignments->pluck('id');
                                    $totalAssignments = $courseAssignmentIds->count();
                                    $submittedCount = \App\Models\Submission::where('student_id', $studentId)
                                        ->whereIn('assignment_id', $courseAssignmentIds)
                                        ->count();
                                    $taskProgressPercentage = $totalAssignments > 0 ? round(($submittedCount / $totalAssignments) * 100) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/1 text-slate-700 dark:text-gray-300">
                                    <td class="p-4 font-bold text-slate-900 dark:text-white flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-brand-purple/10 dark:bg-brand-purple/25 border border-brand-purple/20 dark:border-brand-purple/40 text-brand-purple flex items-center justify-center font-bold text-[10px]">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        <span>{{ $student->name }}</span>
                                    </td>
                                    <td class="p-4 text-slate-500 dark:text-gray-400">{{ $student->email }}</td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3 min-w-[8rem]">
                                            <div class="flex-1 bg-slate-200 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                                                <div class="bg-gradient-brand h-full rounded-full" style="width: {{ $student->pivot->progress_percentage }}%"></div>
                                            </div>
                                            <span class="font-bold text-slate-800 dark:text-white shrink-0">{{ $student->pivot->progress_percentage }}%</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3 min-w-[10rem]">
                                            <div class="flex-1 bg-slate-200 dark:bg-white/5 h-1.5 rounded-full overflow-hidden">
                                                <div class="bg-gradient-to-r from-brand-cyan to-brand-blue h-full rounded-full" style="width: {{ $taskProgressPercentage }}%"></div>
                                            </div>
                                            <span class="font-bold text-slate-800 dark:text-white shrink-0">{{ $taskProgressPercentage }}%</span>
                                            <span class="text-[10px] text-slate-450 dark:text-gray-550 shrink-0">({{ $submittedCount }}/{{ $totalAssignments }})</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-slate-500 dark:text-gray-400">{{ $student->pivot->created_at->format('d M Y') }}</td>
                                    <td class="p-4 text-center">
                                        <button type="button" 
                                                @click="kickStudentName = '{{ $student->name }}'; kickStudentEmail = '{{ $student->email }}'; kickStudentActionUrl = '{{ route('pengajar.courses.kick', [$course->id, $student->id]) }}'; kickConfirmText = ''; kickModalOpen = true"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-red-500/20 bg-red-500/5 hover:bg-red-500/10 text-[10px] font-bold text-red-500 dark:text-red-400 transition-all cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Keluarkan</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Custom Kick Confirmation Modal -->
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="kickModalOpen" x-transition x-cloak style="display: none;">
                <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="kickModalOpen = false">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Keluarkan Siswa?</h3>
                    </div>
                    
                    <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                        <p>Tindakan ini bersifat <strong class="text-red-500 dark:text-red-400">permanen</strong>. Siswa <strong class="text-slate-800 dark:text-white" x-text="kickStudentName"></strong> akan dikeluarkan dari kelas, dan seluruh progres belajar beserta pengumpulan tugasnya akan dihapus selamanya.</p>
                        <p>Ketik <span class="bg-red-500/10 text-red-600 dark:text-red-400 font-mono px-1.5 py-0.5 rounded font-bold" x-text="'keluarkan/' + kickStudentEmail"></span> di bawah untuk mengonfirmasi.</p>
                    </div>

                    <form :action="kickStudentActionUrl" method="POST" class="space-y-3">
                        @csrf
                        @method('DELETE')
                        
                        <input type="text" x-model="kickConfirmText" placeholder="Ketik verifikasi di sini..." required autocomplete="off"
                               class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none focus:border-red-500/50 focus:ring-1 focus:ring-red-500/20 transition-all placeholder-gray-450 dark:placeholder-gray-500">
                        
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="kickModalOpen = false"
                                    class="flex-1 py-2 rounded-lg border border-slate-200 dark:border-white/5 text-xs font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" :disabled="kickConfirmText !== 'keluarkan/' + kickStudentEmail"
                                    class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-lg shadow-red-500/20 transition disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer">
                                Keluarkan Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Custom Delete Course Confirmation Modal -->
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-show="deleteModalOpen" x-transition x-cloak style="display: none;">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full space-y-4 relative border border-red-500/20 shadow-xl shadow-red-500/5" @click.away="deleteModalOpen = false">
            <div class="flex items-center gap-3 border-b border-slate-200 dark:border-white/5 pb-3">
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider font-sans">Hapus Kursus Permanen?</h3>
            </div>
            
            <div class="text-xs text-slate-550 dark:text-gray-400 space-y-2 leading-relaxed">
                <p>Tindakan ini bersifat <strong class="text-red-500 dark:text-red-400">permanen dan tidak bisa dibatalkan</strong>. Seluruh materi pembelajaran, tugas-tugas, file yang diunggah, dan nilai seluruh siswa yang terdaftar di kelas ini akan dihapus selamanya.</p>
                <p>Ketik <span class="bg-red-500/10 text-red-650 dark:text-red-400 font-mono px-1.5 py-0.5 rounded font-bold">hapuskursus</span> di bawah untuk mengonfirmasi.</p>
            </div>

            <form action="{{ route('pengajar.courses.destroy', $course->id) }}" method="POST" class="space-y-3">
                @csrf
                @method('DELETE')
                <input type="text" x-model="deleteConfirmText" placeholder="Ketik verifikasi di sini..." required autocomplete="off"
                       class="w-full bg-white dark:bg-[#121217]/50 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-xs text-slate-850 dark:text-white focus:outline-none focus:border-red-500/50 focus:ring-1 focus:ring-red-500/20 transition-all placeholder-gray-450 dark:placeholder-gray-500">
                
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="deleteModalOpen = false"
                            class="flex-1 py-2 rounded-lg border border-slate-200 dark:border-white/5 text-xs font-bold text-slate-550 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/5 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" :disabled="deleteConfirmText !== 'hapuskursus'"
                            class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-lg shadow-red-500/20 transition disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer">
                        Hapus Kursus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
