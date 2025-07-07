window.purchaseOrderItems = function (vendors) {
    return {
        items: [
            {
                materialId: "",
                materialVendorPriceId: "",
                kuantitas: "",
                mataUang: "",
                vat: "",
                batasDiterima: "",
            },
        ],
        vendorId: null,
        vendors: vendors || [],

        init() {
            const vendorSelect = document.getElementById("vendorId");
            this.vendorId = vendorSelect ? vendorSelect.value : null;

            if (vendorSelect) {
                vendorSelect.addEventListener("change", () => {
                    this.vendorId = vendorSelect.value;
                    this.items.forEach((_, index) =>
                        this.fetchMaterialVendorPrice(index)
                    );
                });
            }

            this.items.forEach((_, index) =>
                this.fetchMaterialVendorPrice(index)
            );
        },

        addItem() {
            this.items.push({
                materialId: "",
                materialVendorPriceId: "",
                kuantitas: "",
                mataUang: "",
                vat: "",
                batasDiterima: "",
            });
        },

        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },

        fetchMaterialVendorPrice(index) {
            const item = this.items[index];
            if (!this.vendorId || !item.materialId) {
                item.materialVendorPriceId = "";
                return;
            }

            fetch(
                `/material-vendor-prices?vendorId=${this.vendorId}&materialId=${item.materialId}`
            )
                .then((response) => response.json())
                .then((data) => {
                    if (data.length > 0) {
                        item.materialVendorPriceId =
                            data[0].idMaterialVendorPrice;
                    } else {
                        item.materialVendorPriceId = "";
                    }
                })
                .catch(() => {
                    item.materialVendorPriceId = "";
                });
        },

        onMaterialChange(index) {
            const item = this.items[index];
            if (item.materialId === "add_new") {
                this.showAddMaterialModal = true;
                // Reset the selected material to empty to avoid invalid selection
                item.materialId = "";
            } else {
                this.fetchMaterialVendorPrice(index);
            }
        },

        addNewMaterial() {
            if (!this.newMaterial.kodeMaterial.trim()) {
                this.addMaterialError = "Kode material tidak boleh kosong.";
                return;
            }
            if (!this.newMaterial.namaMaterial.trim()) {
                this.addMaterialError = "Nama material tidak boleh kosong.";
                return;
            }
            if (!this.newMaterial.satuanMaterial.trim()) {
                this.addMaterialError = "Satuan material tidak boleh kosong.";
                return;
            }
            if (!this.newMaterial.vendorId) {
                this.addMaterialError = "Vendor harus dipilih.";
                return;
            }
            this.addMaterialError = "";

            // Find vendorName from vendors list based on newMaterial.vendorId
            const vendor = this.vendors.find(
                (v) => v.idVendor == this.newMaterial.vendorId
            );
            const vendorName = vendor ? vendor.namaVendor : "";

            // Include vendorId and vendorName in the newMaterial object
            const payload = {
                ...this.newMaterial,
                vendorId: this.newMaterial.vendorId,
                vendorName: vendorName,
            };

            fetch("/materials", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(payload),
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((data) => {
                            this.addMaterialError = Object.values(data.errors)
                                .flat()
                                .join(" ");
                            throw new Error(this.addMaterialError);
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    // Add new material to materials list and select it
                    this.materials.push(data.material);
                    // Find the last added item and set its materialId to new material's id
                    const lastIndex = this.items.length - 1;
                    this.items[lastIndex].materialId = data.material.idMaterial;
                    this.showAddMaterialModal = false;
                    this.newMaterial = {
                        kodeMaterial: "",
                        namaMaterial: "",
                        satuanMaterial: "",
                        deskripsiMaterial: "",
                        harga: 0,
                        mataUang: "",
                        vat: 0,
                        vendorId: "",
                    };
                })
                .catch((error) => {
                    console.error("Error adding material:", error);
                });
        },

        // Add new reactive properties
        showAddMaterialModal: false,
        newMaterial: {
            kodeMaterial: "",
            namaMaterial: "",
            satuanMaterial: "",
            deskripsiMaterial: "",
            harga: 0,
            mataUang: "",
            vat: 0,
            vendorId: "",
        },
        addMaterialError: "",
        materials: [],
    };
};
