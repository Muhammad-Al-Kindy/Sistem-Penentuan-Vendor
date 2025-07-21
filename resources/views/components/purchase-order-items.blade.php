<!-- PURCHASE ORDER ITEMS COMPONENT -->
<div x-data="purchaseOrderItemsComponent()" x-init="() => {
    window.purchaseOrderItemsComponentInstance = $data;
    initializeData();
}" class="mt-6">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-md font-semibold">Material</h2>
        <button type="button" @click="addItem"
            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
            <i class="ri-add-line"></i> Tambah Baris
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm table-fixed mb-4">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="w-1/3 px-4 py-2 text-left">Material</th>
                    <th class="w-1/6 px-4 py-2 text-left">Kuantitas</th>
                    <th class="w-1/6 px-4 py-2 text-left">Mata Uang</th>
                    <th class="w-1/6 px-4 py-2 text-left">VAT</th>
                    <th class="w-1/6 px-4 py-2 text-left">Batas Diterima</th>
                    <th class="w-1/6 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <template x-for="(item, index) in items" :key="index">
                    <tr>
                        <td class="px-4 py-2">
                            <input type="hidden" :name="`items[${index}][id]`" x-model="item.id" />
                            <select :name="`items[${index}][materialId]`" x-model="item.materialId"
                                class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                                @change="onMaterialChange(index)" required>
                                <option value="" disabled>Pilih Material</option>
                                <template x-for="material in mappedMaterials" :key="material.id">
                                    <option :value="material.id" x-text="material.name"
                                        :selected="material.id.toString() === item.materialId.toString()">
                                    </option>
                                </template>
                                <option value="add_new">+ Tambah Material Baru</option>
                            </select>
                            <input type="hidden" :name="`items[${index}][materialVendorPriceId]`"
                                x-model="item.materialVendorPriceId" />
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" min="1" :name="`items[${index}][kuantitas]`"
                                x-model="item.kuantitas"
                                class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                                placeholder="Kuantitas">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" :name="`items[${index}][mataUang]`" x-model="item.mataUang"
                                class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                                placeholder="Mata Uang">
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" min="0" step="0.01" :name="`items[${index}][vat]`"
                                x-model="item.vat"
                                class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                                placeholder="VAT">
                        </td>
                        <td class="px-4 py-2">
                            <input type="date" :name="`items[${index}][batasDiterima]`" x-model="item.batasDiterima"
                                class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" @click="removeItem(index)"
                                class="text-red-500 hover:text-red-700 transition text-sm" title="Hapus Baris"
                                x-show="items.length > 1">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Material -->
    <div x-show="showAddMaterialModal"
        class="fixed inset-0 bg-gray-50 bg-opacity-20 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
            <h3 class="text-lg font-semibold mb-4">Tambah Material Baru</h3>
            <div class="space-y-2">
                <label class="block text-sm">Vendor</label>
                <select x-model="modal.vendorId" class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Vendor</option>
                    <template x-for="vendor in vendors" :key="vendor.idVendor">
                        <option :value="vendor.idVendor" x-text="vendor.namaVendor"></option>
                    </template>
                </select>
                <input type="text" x-model="modal.kodeMaterial" placeholder="Kode Material"
                    class="w-full border rounded px-3 py-2">
                <input type="text" x-model="modal.namaMaterial" placeholder="Nama Material"
                    class="w-full border rounded px-3 py-2">
                <input type="text" x-model="modal.satuanMaterial" placeholder="Satuan Material"
                    class="w-full border rounded px-3 py-2">
                <textarea x-model="modal.deskripsiMaterial" placeholder="Deskripsi Material" class="w-full border rounded px-3 py-2"></textarea>
                <input type="number" x-model="modal.harga" placeholder="Harga" class="w-full border rounded px-3 py-2">
                <input type="text" x-model="modal.mataUang" placeholder="Mata Uang"
                    class="w-full border rounded px-3 py-2">
            </div>
            <div class="text-red-500 mt-2" x-text="addMaterialError"></div>
            <div class="flex justify-end gap-2 mt-4">
                <button @click="showAddMaterialModal = false"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded">Batal</button>
                <button @click="submitNewMaterial" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        function purchaseOrderItemsComponent() {
            return {
                items: [],
                selectedVendorId: null,
                vendors: [],
                materials: [],
                showAddMaterialModal: false,
                modal: {
                    vendorId: '',
                    kodeMaterial: '',
                    namaMaterial: '',
                    satuanMaterial: '',
                    deskripsiMaterial: '',
                    harga: '',
                    mataUang: ''
                },
                addMaterialError: '',

                get mappedMaterials() {
                    return this.materials.map(m => ({
                        id: m.idMaterial,
                        name: m.namaMaterial
                    }));
                },

                initializeData() {
                    this.items = window.initialItems.map(i => ({
                        id: i.id || i.idPurchaseOrderItem || '',
                        materialId: i.materialId?.toString() || '',
                        materialVendorPriceId: i.materialVendorPriceId?.toString() || '',
                        kuantitas: i.kuantitas,
                        mataUang: i.mataUang,
                        vat: i.vat,
                        batasDiterima: i.batasDiterima?.split('T')[0] || ''
                    }));

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
                        id: '',
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
                        this.modal.vendorId = this.selectedVendorId;
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
                        })
                        .catch(() => {
                            this.materials = window.materials;
                        });
                },

                submitNewMaterial() {
                    if (!this.modal.kodeMaterial.trim() || !this.modal.namaMaterial.trim() || !this.modal.vendorId) {
                        this.addMaterialError = 'Vendor, Kode dan Nama Material wajib diisi.';
                        return;
                    }

                    fetch('/materials', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(this.modal)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.material) {
                                this.materials.push(data.material);
                                if (data.material.vendor_id == this.selectedVendorId) {
                                    this.items[this.items.length - 1].materialId = data.material.idMaterial;
                                    this.items[this.items.length - 1].materialVendorPriceId = data.material
                                        .idMaterialVendorPrice || '';
                                }
                                this.showAddMaterialModal = false;
                                this.resetModal();
                            }
                        })
                        .catch(() => {
                            this.addMaterialError = 'Gagal menyimpan material.';
                        });
                },

                resetModal() {
                    this.modal = {
                        vendorId: this.selectedVendorId,
                        kodeMaterial: '',
                        namaMaterial: '',
                        satuanMaterial: '',
                        deskripsiMaterial: '',
                        harga: '',
                        mataUang: ''
                    };
                    this.addMaterialError = '';
                }
            };
        }
    </script>
</div>
