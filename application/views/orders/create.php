<div class="row mb-4">
    <div class="col-12">
        <h3 class="text-primary-dark fw-bold mb-0">Create Sales Order</h3>
        <p class="text-muted mb-0">Record a new transaction</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="<?= base_url('orders/store') ?>" method="post" id="orderForm">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Select Member</label>
                            <select name="member_id" class="form-select" required>
                                <option value="">-- Choose Member --</option>
                                <?php foreach($members as $m): ?>
                                    <option value="<?= $m->member_id ?>"><?= $m->member_name ?> - <?= $m->phone_number ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date</label>
                            <input type="text" class="form-control" value="<?= date('d M Y') ?>" readonly>
                        </div>
                    </div>

                    <h5 class="text-primary-dark fw-bold mb-3 border-bottom pb-2">Order Items</h5>
                    
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered" id="itemsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40%">Product</th>
                                    <th width="20%">Price</th>
                                    <th width="15%">Qty</th>
                                    <th width="20%">Subtotal</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <tr class="item-row">
                                    <td>
                                        <select name="product_id[]" class="form-select product-select" required>
                                            <option value="">-- Select Product --</option>
                                            <?php foreach($products as $p): ?>
                                                <option value="<?= $p->product_id ?>" data-price="<?= $p->price ?>">
                                                    <?= $p->product_code ?> - <?= $p->product_name ?> (Stock: <?= $p->stock ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="price[]" class="form-control price-input" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="quantity[]" class="form-control qty-input" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control subtotal-input" readonly>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-item"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold align-middle">Grand Total:</td>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="grandTotalDisplay" class="form-control fw-bold bg-white" readonly value="0">
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary" id="addItemBtn">
                            <i class="fas fa-plus me-1"></i> Add Another Product
                        </button>
                    </div>

                    <div class="text-end">
                        <a href="<?= base_url('orders') ?>" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="saveOrderBtn">
                            <i class="fas fa-save me-2"></i>Save Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Extra row template for JS -->
<table class="d-none" id="rowTemplate">
    <tr class="item-row">
        <td>
            <select name="product_id[]" class="form-select product-select" required>
                <option value="">-- Select Product --</option>
                <?php foreach($products as $p): ?>
                    <option value="<?= $p->product_id ?>" data-price="<?= $p->price ?>">
                        <?= $p->product_code ?> - <?= $p->product_name ?> (Stock: <?= $p->stock ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="number" name="price[]" class="form-control price-input" readonly>
        </td>
        <td>
            <input type="number" name="quantity[]" class="form-control qty-input" min="1" value="1" required>
        </td>
        <td>
            <input type="number" class="form-control subtotal-input" readonly>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger remove-item"><i class="fas fa-times"></i></button>
        </td>
    </tr>
</table>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {
    
    function calculateTotals() {
        let grandTotal = 0;
        $('.item-row').each(function() {
            let price = parseFloat($(this).find('.price-input').val()) || 0;
            let qty = parseInt($(this).find('.qty-input').val()) || 0;
            let subtotal = price * qty;
            
            $(this).find('.subtotal-input').val(subtotal);
            grandTotal += subtotal;
        });
        
        $('#grandTotalDisplay').val(grandTotal.toLocaleString('id-ID'));
    }

    // On product change
    $(document).on('change', '.product-select', function() {
        let price = $(this).find(':selected').data('price');
        $(this).closest('tr').find('.price-input').val(price);
        calculateTotals();
    });

    // On quantity change
    $(document).on('input', '.qty-input', function() {
        calculateTotals();
    });

    // Add item
    $('#addItemBtn').click(function() {
        let newRow = $('#rowTemplate tbody').html();
        $('#itemsBody').append(newRow);
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        if($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot Remove',
                text: 'Order must have at least one item.'
            });
        }
    });

    // Form submit validation
    $('#orderForm').submit(function(e) {
        let valid = true;
        $('#itemsBody .product-select').each(function() {
            if($(this).val() == '') {
                valid = false;
            }
        });
        if(!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select a product for all rows.'
            });
        }
    });
});
</script>
