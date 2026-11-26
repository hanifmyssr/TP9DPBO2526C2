<?php
class Lowongan {
    private ?int $id;
    private string $judulPosisi;
    private string $departemen;
    private string $lokasi;
    private int $kuota;
    private string $status;

    public function __construct(
        ?int $id,
        string $judulPosisi,
        string $departemen,
        string $lokasi,
        int $kuota,
        string $status
    ) {
        $this->id = $id;
        $this->judulPosisi = $judulPosisi;
        $this->departemen = $departemen;
        $this->lokasi = $lokasi;
        $this->kuota = $kuota;
        $this->status = $status;
    }

    public function getId(): ?int { return $this->id; }
    public function getJudulPosisi(): string { return $this->judulPosisi; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getLokasi(): string { return $this->lokasi; }
    public function getKuota(): int { return $this->kuota; }
    public function getStatus(): string { return $this->status; }

    public function setJudulPosisi(string $judulPosisi): void { $this->judulPosisi = $judulPosisi; }
    public function setDepartemen(string $departemen): void { $this->departemen = $departemen; }
    public function setLokasi(string $lokasi): void { $this->lokasi = $lokasi; }
    public function setKuota(int $kuota): void { $this->kuota = $kuota; }
    public function setStatus(string $status): void { $this->status = $status; }
}
?>
