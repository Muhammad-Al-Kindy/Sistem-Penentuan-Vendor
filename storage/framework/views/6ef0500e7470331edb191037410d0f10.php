<!-- PURCHASE ORDER ITEMS COMPONENT -->
<div x-data="purchaseOrderItemsComponent()" x-init="() => {
    window.purchaseOrderItemsComponentInstance = $data;
    initializeData();
}" class="mt-6">


    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm table-fixed mb-4">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="w-1/3 px-4 py-2 text-left">Material</th>
                    <th class="w-1/6 px-4 py-2 text-left">Kuantitas</th>
                    <th class="w-1/6 px-4 py-2 text-left">Mata Uang</th>
                    <th class="w-1/6 px-4 py-2 text-left">VAT</th>
                    <th class="w-1/6 px-4 py-2 text-left">Batas Diterima</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <template x-for="(item, index) in items" :key="index">
                    <tr>
                        <!-- MATERIAL (readonly + hidden) -->
                        <td class="px-4 py-2">
                            <input type="hidden" :name="`items[${index}][id]`" x-model="item.id" />
                            <input type="hidden" :name="`items[${index}][materialId]`" x-model="item.materialId" />
                            <input type="hidden" :name="`items[${index}][materialVendorPriceId]`"
                                x-model="item.materialVendorPriceId" />
                            <div class="px-2 py-1 border rounded bg-gray-100 text-gray-700">
                                <template
                                    x-if="material = mappedMaterials.find(m => m.id === parseInt(item.materialId))">
                                    <span x-text="material?.name"></span>
                                </template>
                            </div>
                        </td>

                        <!-- KUANTITAS -->
                        <td class="px-4 py-2">
                            <input type="hidden" :name="`items[${index}][kuantitas]`" :value="item.kuantitas" />
                            <div class="px-2 py-1 border rounded bg-gray-100 text-gray-700">
                                <span x-text="item.kuantitas"></span>
                            </div>
                        </td>

                        <!-- MATA UANG -->
                        <td class="px-4 py-2">
                            <input type="hidden" :name="`items[${index}][mataUang]`" :value="item.mataUang" />
                            <div class="px-2 py-1 border rounded bg-gray-100 text-gray-700">
                                <span x-text="item.mataUang"></span>
                            </div>
                        </td>

                        <!-- VAT -->
                        <td class="px-4 py-2">
                            <input type="hidden" :name="`items[${index}][vat]`" :value="item.vat" />
                            <div class="px-2 py-1 border rounded bg-gray-100 text-gray-700">
                                <span x-text="item.vat"></span>
                            </div>
                        </td>

                        <!-- BATAS DITERIMA -->
                        <td class="px-4 py-2">
                            <input type="hidden" :name="`items[${index}][batasDiterima]`"
                                :value="item.batasDiterima" />
                            <div class="px-2 py-1 border rounded bg-gray-100 text-gray-700">
                                <span x-text="item.batasDiterima"></span>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>

        </table>
    </div>

    <script>
        function purchaseOrderItemsComponent() {
            return {
                items: [],
                selectedVendorId: null,
                vendors: [],
                materials: [],
                showAddMaterialModal: false,

                get mappedMaterials() {
                    return this.materials.map(m => ({
                        id: m.idMaterial,
                        name: m.namaMaterial
                    }));
                },

                initializeData() {
                    this.items = window.initialItems.map(i => ({
                        id: i.id || i.idPurchaseOrderItem || '', // PERBAIKAN
                        materialId: i.materialId?.toString() || '',
                        materialVendorPriceId: i.materialVendorPriceId?.toString() || '',
                        kuantitas: i.kuantitas,
                        mataUang: i.mataUang,
                        vat: i.vat,
                        batasDiterima: i.batasDiterima?.split('T')[0] || ''
                    }));

                    console.log('Alpine initialized items:', this.items);

                    this.selectedVendorId = window.initialVendorId;
                    this.vendors = window.vendors;
                    this.materials = window.materials;

                    if (this.selectedVendorId) {
                        this.fetchMaterialsByVendor();
                    }

                    const vendorSelect = document.getElementById('vendorId');
                    if (vendorSelect) {
                        vendorSelect.addEventListener('change', () => {
                            this.selectedVendorId = vendorSelect.value;
                            this.fetchMaterialsByVendor();
                            this.items.forEach((_, index) => this.fetchMaterialVendorPrice(index));
                        });
                    }

                    this.items.forEach((_, index) => this.fetchMaterialVendorPrice(index));
                },


                addItem() {
                    this.items.push({
                        id: '', // PENTING untuk validasi
                        materialId: '',
                        materialVendorPriceId: '',
                        kuantitas: '',
                        mataUang: '',
                        vat: 0,
                        batasDiterima: ''
                    });
                },

                removeItem(index) {
                    if (this.items.length > 1) this.items.splice(index, 1);
                },

                onMaterialChange(index) {
                    const item = this.items[index];
                    if (item.materialId === 'add_new') {
                        this.showAddMaterialModal = true;
                        item.materialId = '';
                    } else {
                        this.fetchMaterialVendorPrice(index);
                    }
                },

                fetchMaterialVendorPrice(index) {
                    const item = this.items[index];
                    if (!this.selectedVendorId || !item.materialId) return;

                    fetch(`/material-vendor-prices?vendorId=${this.selectedVendorId}&materialId=${item.materialId}`)
                        .then(res => res.json())
                        .then(data => {
                            item.materialVendorPriceId = data[0]?.idMaterialVendorPrice || '';
                        })
                        .catch(() => {
                            item.materialVendorPriceId = '';
                        });
                },

                fetchMaterialsByVendor() {
                    if (!this.selectedVendorId) {
                        this.materials = window.materials;
                        return;
                    }

                    fetch(`/materials-by-vendor?vendorId=${this.selectedVendorId}`)
                        .then(response => response.json())
                        .then(data => {
                            this.materials = data.materials || [];

                            this.items.forEach(item => {
                                if (!item.materialId) item.materialId = '';
                            });
                        })
                        .catch(() => {
                            this.materials = window.materials;
                        });
                }
            };
        }
    </script>
</div>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/components/purchase-order-items-vendor.blade.php ENDPATH**/ ?>