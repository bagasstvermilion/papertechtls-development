<div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <h1 style="color: #003366;">Selamat Datang, <?php echo $this->session->userdata('nmuser'); ?>! 👋</h1>
    <p>Ini adalah portal Logbook Automation PT Papertech Indonesia. Hak akses kamu saat ini adalah: <b><?php echo strtoupper($this->session->userdata('role')); ?></b> .</p>
    <p>Silakan gunakan menu di sebelah kiri untuk mulai bekerja.</p>
</div>