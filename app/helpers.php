<?php

if (!function_exists('applyTajwid')) {
    function applyTajwid($text)
    {
        if (empty($text)) return '';

        // Ghunnah (Nun/Mim bertasydid) - MERAH
        $text = preg_replace('/[نّ]/u', '<span class="tajwid-ghunnah">$0</span>', $text);
        $text = preg_replace('/[مّ]/u', '<span class="tajwid-ghunnah">$0</span>', $text);

        // Qalqalah (ق ط ب ج د) - UNGU
        $text = preg_replace('/[ق]/u', '<span class="tajwid-qalqalah">$0</span>', $text);
        $text = preg_replace('/[ط]/u', '<span class="tajwid-qalqalah">$0</span>', $text);
        $text = preg_replace('/[ب]/u', '<span class="tajwid-qalqalah">$0</span>', $text);
        $text = preg_replace('/[ج]/u', '<span class="tajwid-qalqalah">$0</span>', $text);
        $text = preg_replace('/[د]/u', '<span class="tajwid-qalqalah">$0</span>', $text);

        // Mad (ا و ي) - BIRU
        $text = preg_replace('/[ا]/u', '<span class="tajwid-mad">$0</span>', $text);
        $text = preg_replace('/[و]/u', '<span class="tajwid-mad">$0</span>', $text);
        $text = preg_replace('/[ي]/u', '<span class="tajwid-mad">$0</span>', $text);

        return $text;
    }
}
