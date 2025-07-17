<div x-data="{ open: false }" class="mb-6 border border-gray-300 rounded-lg">
    <button @click="open = !open" type="button"
        class="w-full flex justify-between items-center px-4 py-3 text-left text-gray-700 font-semibold focus:outline-none">
        <span class="text-lg font-medium">RFQ Details</span>
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
        </svg>
    </button>
    <div x-show="open" x-transition class="p-4 border-t border-gray-300 bg-gray-50" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-row sm:gap-3 md:gap-10 ">
                <div class="w-full">
                    <label for="no_rfq" class="block mb-1 font-medium text-gray-700">No RFQ <span
                            class="opacity-50">(Optional)</span></label>
                    <input type="text" name="no_rfq" id="no_rfq"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nomor RFQ">
                </div>
                <div class="w-full">
                    <label for="rfq_collective" class="block mb-1 font-medium text-gray-700">RFQ Collective <span
                            class="opacity-50">(Optional)</span></label>
                    <input type="text" name="rfq_collective" id="rfq_collective"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="RFQ Collective">
                </div>
            </div>
            <div class="flex flex-row sm:gap-3 md:gap-10 ">
                <div class="w-full">
                    <label for="referensi_sph" class="block mb-1 font-medium text-gray-700">Referensi SPH <span
                            class="opacity-50">(Optional)</span></label>
                    <input type="text" name="referensi_sph" id="referensi_sph"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Referensi SPH">
                </div>
                <div class="w-full">
                    <label for="no_justifikasi" class="block mb-1 font-medium text-gray-700">No Justifikasi <span
                            class="opacity-50">(Optional)</span></label>
                    <input type="text" name="no_justifikasi" id="no_justifikasi"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="No Justifikasi">
                </div>
            </div>
            <div>
                <label for="no_negosiasi" class="block mb-1 font-medium text-gray-700">No Negosiasi <span
                        class="opacity-50">(Optional)</span></label>
                <input type="text" name="no_negosiasi" id="no_negosiasi"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="No Negosiasi">
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/components/rfq-form.blade.php ENDPATH**/ ?>