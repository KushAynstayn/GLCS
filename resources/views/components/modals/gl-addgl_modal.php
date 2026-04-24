<div id="modal-gl-addgl" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
        
        <div class="p-6 pb-0 flex items-start gap-4">
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Add New GL Code</h3>
                <p class="text-sm text-gray-500">Define a new General Ledger account and its hierarchy.</p>
            </div>
        </div>

        <form id="addGlForm" action="process_gl.php" method="POST" class="p-6 space-y-4">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">GL Account</label>
                    <input type="text" name="gl_account" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Account Title</label>
                    <select name="account_title" required class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Title</option>
                        <option value="teller_cash_peso">Teller Cash Peso</option>
                        <option value="vault_cash_kwon">Vault Cash Korean Won</option>
                        <option value="cib_bpi">Cash in Bank - BPI</option>
                        <option value="df_vpo">Disbursing Fund - VPO VisMin</option>
                        <option value="rf_all">Revolving Fund - Amparito Llamas Lhuillier Division</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Level 4</label>
                    <select name="level_4" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 4</option>
                        <option value="cash_hand">Cash on Hand</option>
                        <option value="cash_bank">Cash in Bank</option>
                        <option value="revolving">Revolving Fund Support</option>
                        <option value="quick_loan">Quick Cash Loan</option>
                        <option value="ml_loans">ML Loans</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Level 3</label>
                    <select name="level_3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 3</option>
                        <option value="cash_equiv">Cash and Cash Equivalent</option>
                        <option value="trade_receiv">Trade Accounts Receivable</option>
                        <option value="gold_inv">Gold Inventory</option>
                        <option value="merch_inv">Merchandise Inventory</option>
                        <option value="supplies_inv">Supplies Inventory</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Level 2</label>
                    <select name="level_2" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 2</option>
                        <option value="curr_asset">Current Asset</option>
                        <option value="non_curr_asset">Non Current Asset</option>
                        <option value="other_non_curr">Other Non Current Asset</option>
                        <option value="curr_liab">Current Liabilities</option>
                        <option value="non_curr_liab">Non Current Liabilities</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Level 1</label>
                    <select name="level_1" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 1</option>
                        <option value="asset">Asset</option>
                        <option value="liab">Liabilities</option>
                        <option value="capital">Capital</option>
                        <option value="rev">Revenues</option>
                        <option value="exp">Expenses</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">FS Account Type</label>
                    <select name="fs_account_type" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="bs">Balance Sheet</option>
                        <option value="is">Income Statement</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Normal Balance</label>
                    <select name="normal_balance" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="DR">Debit (DR)</option>
                        <option value="CR">Credit (CR)</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('gl-addgl')" 
                    class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transition-all">
                    Save GL Code
                </button>
            </div>
        </form>
    </div>
</div>