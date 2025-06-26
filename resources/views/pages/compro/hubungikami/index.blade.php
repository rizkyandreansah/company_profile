@extends('layouts.compro')

@section('style')
<link href="{{ asset('compro/css/section/hubungikami.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<section class="hubungi-section">
        <div class="container">
            <div class="hubungi-content">
                <!-- Form Section -->
                <div class="form-section">
                    <h2 class="form-title">Hubungi Kami</h2>

                    <form id="consultationForm">
                        @csrf
                        <div class="form-group">
                            <label for="fullName">Nama Lengkap*</label>
                            <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Masukkan nama lengkap anda" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email anda" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">No Telepon*</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Masukkan nomor telepon" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Pesan*</label>
                            <textarea id="message" name="message" class="form-control textarea" placeholder="Kirimkan pesan anda" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> <span class="btn-text">Kirim Pesan</span>
                        </button>
                    </form>
                </div>

                <!-- Office Info Section -->
                <div class="office-info">
                    <div class="office-card">
                        <h2 class="office-title">Alamat Kantor</h2>

                        <!-- Office Address -->
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Kantor Kami</h4>
                                <p>{{ $alamatKantor->alamat ?? 'Alamat belum tersedia' }}</p>
                            </div> 
                        </div>

                        <!-- Phone Numbers -->
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Nomor Telepon</h4>
                                <p>{{ $alamatKantor->no_telepon ?? 'Nomor telepon belum tersedia' }}</p>
                            </div>
                        </div>

                        <!-- Email Support -->
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Email</h4>
                                <p>{{ $alamatKantor->email ?? 'Email belum tersedia' }}</p>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="map-container">
                            @if($alamatKantor && $alamatKantor->link_maps)
                                <iframe 
                                    src="{{ $alamatKantor->link_maps }}" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @else
                                <div class="no-map-available" style="height: 300px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px;">
                                    <p style="color: #6c757d; text-align: center;">
                                        <i class="fas fa-map-marker-alt" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                                        Peta belum tersedia
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Modal -->
        <div id="notificationOverlay" class="notification-overlay">
            <div id="notificationModal" class="notification-modal">
                <div id="notificationIcon" class="notification-icon fas fa-check-circle"></div>
                <h3 id="notificationTitle" class="notification-title">Berhasil!</h3>
                <p id="notificationText" class="notification-text">Pesan Anda berhasil dikirim!</p>
                <div class="notification-buttons">
                    <button id="notificationOk" class="notification-btn primary">OK</button>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>
// Setup CSRF token for AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Modal Notification System
function showNotification(title, message, type = 'success') {
    const overlay = document.getElementById('notificationOverlay');
    const modal = document.getElementById('notificationModal');
    const icon = document.getElementById('notificationIcon');
    const titleEl = document.getElementById('notificationTitle');
    const text = document.getElementById('notificationText');
    
    // Set content
    titleEl.textContent = title;
    text.textContent = message;
    
    // Set type and icon
    modal.className = `notification-modal ${type}`;
    if (type === 'success') {
        icon.className = 'notification-icon fas fa-check-circle';
    } else if (type === 'error') {
        icon.className = 'notification-icon fas fa-exclamation-circle';
    }
    
    // Show modal
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden'; // Prevent background scroll
}

function hideNotification() {
    const overlay = document.getElementById('notificationOverlay');
    overlay.classList.remove('show');
    document.body.style.overflow = ''; // Restore scroll
}

// Form submission handler
document.getElementById('consultationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    
    // Disable button and show loading
    submitBtn.disabled = true;
    btnText.textContent = 'Mengirim...';
    
    // Get form data
    const formData = {
        fullName: document.getElementById('fullName').value.trim(),
        email: document.getElementById('email').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        message: document.getElementById('message').value.trim(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    // Client-side validation
    if (!formData.fullName || !formData.email || !formData.phone || !formData.message) {
        showNotification('Gagal Mengirim', 'Mohon lengkapi semua field yang diperlukan!', 'error');
        // Re-enable button
        submitBtn.disabled = false;
        btnText.textContent = 'Kirim Pesan';
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(formData.email)) {
        showNotification('Gagal Mengirim', 'Format email tidak valid!', 'error');
        // Re-enable button
        submitBtn.disabled = false;
        btnText.textContent = 'Kirim Pesan';
        return;
    }
    
    // Phone validation (basic)
    if (formData.phone.length < 10) {
        showNotification('Gagal Mengirim', 'Nomor telepon minimal 10 digit!', 'error');
        // Re-enable button
        submitBtn.disabled = false;
        btnText.textContent = 'Kirim Pesan';
        return;
    }
    
    // Send data to server
    fetch('{{ route("hubungikami.submit") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': formData._token,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        return response.json().then(data => {
            if (!response.ok) {
                throw new Error(data.message || 'Network response was not ok');
            }
            return data;
        });
    })
    .then(data => {
        if (data.status === 'success') {
            showNotification('Berhasil Dikirim!', data.message, 'success');
            this.reset(); // Reset form
        } else {
            showNotification('Gagal Mengirim', data.message || 'Terjadi kesalahan yang tidak diketahui', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal Mengirim', error.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        btnText.textContent = 'Kirim Pesan';
    });
});

// Close notification handlers
document.getElementById('notificationOk').addEventListener('click', function() {
    hideNotification();
});

// Close on overlay click
document.getElementById('notificationOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        hideNotification();
    }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideNotification();
    }
});

// Form interactive effects
const formControls = document.querySelectorAll('.form-control');
formControls.forEach(control => {
    control.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    control.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
});
</script>       
@endsection