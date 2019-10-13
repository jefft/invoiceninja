<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('languages', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('locale');
        });

        Schema::create('countries', function ($table) {
            $table->increments('id');
            $table->string('capital', 255)->nullable();
            $table->string('citizenship', 255)->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('currency_code', 255)->nullable();
            $table->string('currency_sub_unit', 255)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('iso_3166_2', 2)->nullable();
            $table->string('iso_3166_3', 3)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('region_code', 3)->nullable();
            $table->string('sub_region_code', 3)->nullable();
            $table->boolean('eea')->default(0);
            $table->boolean('swap_postal_code')->default(0);
            $table->boolean('swap_currency_symbol')->default(false);
            $table->string('thousand_separator')->nullable();
            $table->string('decimal_separator')->nullable();
        });

        Schema::create('payment_types', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('gateway_type_id')->nullable();
        });

        Schema::create('timezones', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->integer('utc_offset')->default(0);
        });

        Schema::create('currencies', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->string('precision');
            $table->string('thousand_separator');
            $table->string('decimal_separator');
            $table->string('code');
            $table->boolean('swap_currency_symbol')->default(false);

        });

        Schema::create('sizes', function ($table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('industries', function ($table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('gateways', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('key')->unique();
            $table->string('provider');
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });

        Schema::create('accounts', function ($table) {

            $table->increments('id');

            $table->enum('plan', ['pro', 'enterprise', 'white_label'])->nullable();
            $table->enum('plan_term', ['month', 'year'])->nullable();
            $table->date('plan_started')->nullable();
            $table->date('plan_paid')->nullable();
            $table->date('plan_expires')->nullable();

            $table->unsignedInteger('payment_id')->nullable()->index();
            $table->unsignedInteger('default_company_id');

            $table->date('trial_started')->nullable();
            $table->enum('trial_plan', ['pro', 'enterprise'])->nullable();

            $table->enum('pending_plan', ['pro', 'enterprise', 'free'])->nullable();
            $table->enum('pending_term', ['month', 'year'])->nullable();

            $table->decimal('plan_price', 7, 2)->nullable();
            $table->decimal('pending_plan_price', 7, 2)->nullable();
            $table->smallInteger('num_users')->default(1);
            $table->smallInteger('pending_num_users')->default(1);

            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();

            $table->float('discount')->default(0);
            $table->date('discount_expires')->nullable();

            $table->enum('bluevine_status', ['ignored', 'signed_up'])->nullable();
            $table->string('referral_code')->nullable();

            $table->timestamps(6);
            $table->softDeletes();
        });
        
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name')->nullable();
            $table->unsignedInteger('account_id')->index();
            $table->unsignedInteger('industry_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('company_key',100)->unique();
            $table->string('logo')->nullable();
            // $table->string('website')->nullable();
            // $table->string('address1')->nullable();
            // $table->string('address2')->nullable();
            // $table->string('city')->nullable();
            // $table->string('state')->nullable();
            // $table->string('postal_code')->nullable();
            // $table->string('phone')->nullable();
            // $table->string('email')->nullable();
            // $table->unsignedInteger('country_id')->nullable();
            $table->string('domain')->nullable();
            $table->string('db')->nullable();
            // $table->string('vat_number')->nullable();
            // $table->string('id_number')->nullable();
            $table->unsignedInteger('size_id')->nullable();
            $table->string('first_day_of_week')->nullable();
            $table->string('financial_year_start')->nullable();
            $table->smallInteger('enable_modules')->default(0);
            $table->text('custom_fields');
            $table->text('settings');
            
            $table->timestamps(6);
            $table->softDeletes();
            
            //$table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('industry_id')->references('id')->on('industries');
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');


        });


        Schema::create('company_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('user_id')->index();
            $table->text('permissions')->nullable();
            $table->text('settings')->nullable();
            $table->boolean('is_owner')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_locked')->default(false); // locks user out of account

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->index(['account_id', 'company_id']);

        });

        Schema::create('documents', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('company_id')->index();
            $table->string('path')->nullable();
            $table->string('preview')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('disk')->nullable();
            $table->string('hash', 100)->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->boolean('is_default')->default(0);

            $table->unsignedInteger('documentable_id');
            $table->string('documentable_type');
            $table->timestamps(6);

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

        });
         
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('confirmation_code')->nullable();
            $table->integer('theme_id')->nullable();
            $table->smallInteger('failed_logins')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('oauth_user_id',100)->nullable();
            $table->string('oauth_provider_id')->nullable();
            $table->string('google_2fa_secret')->nullable();
            $table->string('accepted_terms_version')->nullable();
            $table->string('avatar', 100)->nullable();
            $table->unsignedInteger('avatar_width')->nullable();
            $table->unsignedInteger('avatar_height')->nullable();
            $table->unsignedInteger('avatar_size')->nullable();
            $table->datetime('last_login')->nullable();
            $table->text('signature')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            $table->timestamps(6);
            $table->softDeletes();

            $table->unique(['oauth_user_id', 'oauth_provider_id']);


           // $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

        });


        Schema::create('company_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('user_id');
            $table->string('token')->nullable();
            $table->string('name')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('clients', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('user_id')->index();

            $table->string('name')->nullable();
            $table->string('website')->nullable();
            $table->text('private_notes')->nullable();
            $table->text('client_hash')->nullable();
            $table->string('logo', 255)->nullable();

            $table->decimal('balance', 13, 2)->default(0);
            $table->decimal('paid_to_date', 13, 2)->default(0);
            $table->timestamp('last_login')->nullable();
            $table->unsignedInteger('industry_id')->nullable();
            $table->unsignedInteger('size_id')->nullable();
//            $table->unsignedInteger('currency_id')->nullable();

            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('custom_value1')->nullable();
            $table->string('custom_value2')->nullable();
            $table->string('custom_value3')->nullable();
            $table->string('custom_value4')->nullable();

            $table->string('shipping_address1')->nullable();
            $table->string('shipping_address2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->unsignedInteger('shipping_country_id')->nullable();
            $table->text('settings')->nullable();

            $table->boolean('is_deleted')->default(false);
            $table->unsignedInteger('group_settings_id')->nullable();  
            $table->string('vat_number')->nullable();
            $table->string('id_number')->nullable();

            $table->timestamps(6);
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('industry_id')->references('id')->on('industries');
            $table->foreign('size_id')->references('id')->on('sizes');
//            $table->foreign('currency_id')->references('id')->on('currencies');

        });

        Schema::create('client_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('client_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('custom_value1')->nullable();
            $table->string('custom_value2')->nullable();
            $table->string('custom_value3')->nullable();
            $table->string('custom_value4')->nullable();
            $table->string('email',100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('confirmation_code')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('confirmed')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->smallInteger('failed_logins')->nullable();
            $table->string('oauth_user_id',100)->nullable()->unique();
            $table->unsignedInteger('oauth_provider_id')->nullable()->unique();
            $table->string('google_2fa_secret')->nullable();
            $table->string('accepted_terms_version')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('avatar_type',255)->nullable();
            $table->string('avatar_size',255)->nullable();
            $table->string('password');
            $table->string('token')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->boolean('send_invoice')->default(true);
            $table->string('contact_key')->nullable();
            $table->rememberToken();
            $table->timestamps(6);
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            //$table->unique(['company_id', 'email']);
        });


        Schema::create('company_gateways', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('user_id');
            $table->string('gateway_key');
            $table->unsignedInteger('accepted_credit_cards');
            $table->boolean('require_cvv')->default(true);
            $table->boolean('show_address')->default(true)->nullable();
            $table->boolean('show_shipping_address')->default(true)->nullable();
            $table->boolean('update_details')->default(false)->nullable();
            $table->text('config');
            $table->unsignedInteger('priority_id')->default(0);

            $table->decimal('min_limit', 13, 2)->nullable();
            $table->decimal('max_limit', 13, 2)->nullable();
            $table->decimal('fee_amount', 13, 2)->nullable();
            $table->decimal('fee_percent', 13, 2)->nullable();
            $table->string('fee_tax_name1')->nullable();
            $table->string('fee_tax_name2')->nullable();
            $table->string('fee_tax_name3')->nullable();
            $table->decimal('fee_tax_rate1', 13, 2)->nullable();
            $table->decimal('fee_tax_rate2', 13, 2)->nullable();
            $table->decimal('fee_tax_rate3', 13, 2)->nullable();
            $table->unsignedInteger('fee_cap')->default(0);
            $table->boolean('adjust_fee_percent');

            $table->timestamps(6);
            $table->softDeletes();


            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('gateway_key')->references('key')->on('gateways');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });


        Schema::create('invoices', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('client_id')->index();
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('company_id')->index();
            $t->unsignedInteger('status_id');

            $t->unsignedInteger('recurring_invoice_id')->nullable();

            $t->string('invoice_number')->nullable();
            $t->float('discount')->default(0);
            $t->boolean('is_amount_discount')->default(0);

            $t->string('po_number')->nullable();
            $t->date('invoice_date')->nullable();
            $t->datetime('due_date')->nullable();

            $t->boolean('is_deleted')->default(false);

            $t->text('line_items')->nullable();
            $t->text('settings')->nullable();
            $t->text('backup')->nullable();

            $t->text('footer')->nullable();
            $t->text('public_notes')->nullable();
            $t->text('private_notes')->nullable();
            $t->text('terms')->nullable();

            $t->string('tax_name1')->nullable();
            $t->decimal('tax_rate1', 13, 3)->default(0);

            $t->string('tax_name2')->nullable();
            $t->decimal('tax_rate2', 13, 3)->default(0);

            $t->string('tax_name3')->nullable();
            $t->decimal('tax_rate3', 13, 3)->default(0);

            $t->string('custom_value1')->nullable();
            $t->string('custom_value2')->nullable();
            $t->string('custom_value3')->nullable();
            $t->string('custom_value4')->nullable();

            $t->string('custom_surcharge1')->nullable();
            $t->string('custom_surcharge2')->nullable();
            $t->string('custom_surcharge3')->nullable();
            $t->string('custom_surcharge4')->nullable();

            $t->decimal('amount', 13, 2);
            $t->decimal('balance', 13, 2);
            $t->decimal('partial', 13, 2)->nullable();
            $t->datetime('partial_due_date')->nullable();

            $t->datetime('last_viewed')->nullable();

            $t->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $t->timestamps(6);
            $t->softDeletes();

            $t->unique(['company_id', 'invoice_number']);
        });

        Schema::create('recurring_invoices', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('client_id')->index();
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('company_id')->index();

            $t->unsignedInteger('status_id')->index();
            $t->text('invoice_number')->nullable();

            $t->float('discount')->default(0);
            $t->boolean('is_amount_discount')->default(false);

            $t->string('po_number')->nullable();
            $t->date('invoice_date')->nullable();
            $t->datetime('due_date')->nullable();

            $t->boolean('is_deleted')->default(false);

            $t->text('line_items')->nullable();
            $t->text('settings')->nullable();
            $t->text('backup')->nullable();

            $t->text('footer')->nullable();
            $t->text('public_notes')->nullable();
            $t->text('private_notes')->nullable();
            $t->text('terms')->nullable();


            $t->string('tax_name1')->nullable();
            $t->decimal('tax_rate1', 13, 3)->default(0);

            $t->string('tax_name2')->nullable();
            $t->decimal('tax_rate2', 13, 3)->default(0);

            $t->string('tax_name3')->nullable();
            $t->decimal('tax_rate3', 13, 3)->default(0);

            $t->string('custom_value1')->nullable();
            $t->string('custom_value2')->nullable();
            $t->string('custom_value3')->nullable();
            $t->string('custom_value4')->nullable();

            $t->decimal('amount', 13, 2);
            $t->decimal('balance', 13, 2);
            $t->decimal('partial', 13, 2)->nullable();

            $t->datetime('last_viewed')->nullable();

            $t->unsignedInteger('frequency_id');
            $t->datetime('start_date')->nullable();
            $t->datetime('last_sent_date')->nullable();
            $t->datetime('next_send_date')->nullable();
            $t->unsignedInteger('remaining_cycles')->nullable();

            $t->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $t->timestamps(6);
            $t->softDeletes();

        });

        Schema::create('recurring_quotes', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('client_id')->index();
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('company_id')->index();

            $t->unsignedInteger('status_id')->index();

            $t->float('discount')->default(0);
            $t->boolean('is_amount_discount')->default(false);
            $t->string('quote_number')->nullable();

            $t->string('po_number')->nullable();
            $t->date('quote_date')->nullable();
            $t->datetime('valid_until')->nullable();

            $t->boolean('is_deleted')->default(false);

            $t->text('line_items')->nullable();
            $t->text('settings')->nullable();
            $t->text('backup')->nullable();

            $t->text('footer')->nullable();
            $t->text('public_notes')->nullable();
            $t->text('private_notes')->nullable();
            $t->text('terms')->nullable();

            $t->string('tax_name1')->nullable();
            $t->decimal('tax_rate1', 13, 3)->default(0);

            $t->string('tax_name2')->nullable();
            $t->decimal('tax_rate2', 13, 3)->default(0);

            $t->string('tax_name3')->nullable();
            $t->decimal('tax_rate3', 13, 3)->default(0);

            $t->string('custom_value1')->nullable();
            $t->string('custom_value2')->nullable();
            $t->string('custom_value3')->nullable();
            $t->string('custom_value4')->nullable();

            $t->decimal('amount', 13, 2)->default(0);
            $t->decimal('balance', 13, 2)->default(0);

            $t->datetime('last_viewed')->nullable();

            $t->unsignedInteger('frequency_id');
            $t->date('start_date')->nullable();
            $t->datetime('last_sent_date')->nullable();
            $t->datetime('next_send_date')->nullable();
            $t->unsignedInteger('remaining_cycles')->nullable();

            $t->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $t->timestamps(6);
            $t->softDeletes();

        });

        Schema::create('quotes', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('client_id')->index();
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('company_id')->index();
            $t->unsignedInteger('status_id');

            $t->string('quote_number')->nullable();
            $t->float('discount')->default(0);
            $t->boolean('is_amount_discount')->default(false);

            $t->string('po_number')->nullable();
            $t->date('quote_date')->nullable();
            $t->datetime('valid_until')->nullable();

            $t->boolean('is_deleted')->default(false);

            $t->text('line_items')->nullable();
            $t->text('settings')->nullable();
            $t->text('backup')->nullable();

            $t->text('footer')->nullable();
            $t->text('public_notes')->nullable();
            $t->text('private_notes')->nullable();
            $t->text('terms')->nullable();


            $t->string('tax_name1')->nullable();
            $t->decimal('tax_rate1', 13, 3)->default(0);

            $t->string('tax_name2')->nullable();
            $t->decimal('tax_rate2', 13, 3)->default(0);

            $t->string('tax_name3')->nullable();
            $t->decimal('tax_rate3', 13, 3)->default(0);

            $t->string('custom_value1')->nullable();
            $t->string('custom_value2')->nullable();
            $t->string('custom_value3')->nullable();
            $t->string('custom_value4')->nullable();

            $t->decimal('amount', 13, 2)->default(0);
            $t->decimal('balance', 13, 2)->default(0);
            $t->decimal('partial', 13, 2)->nullable();
            $t->datetime('partial_due_date')->nullable();

            $t->datetime('last_viewed')->nullable();

            $t->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $t->timestamps(6);
            $t->softDeletes();

            $t->unique(['company_id', 'quote_number']);
        });

        Schema::create('invoice_invitations', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('company_id');
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('client_contact_id');
            $t->unsignedInteger('invoice_id')->index();
            $t->string('invitation_key')->index()->unique();
            $t->timestamps(6);
            $t->softDeletes();

            $t->string('transaction_reference')->nullable();
            $t->string('message_id')->nullable();
            $t->text('email_error')->nullable();
            $t->text('signature_base64')->nullable();
            $t->datetime('signature_date')->nullable();

            $t->datetime('sent_date')->nullable();
            $t->datetime('viewed_date')->nullable();
            $t->datetime('opened_date')->nullable();

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $t->foreign('client_contact_id')->references('id')->on('client_contacts')->onDelete('cascade');
            $t->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $t->index(['deleted_at', 'invoice_id']);

        });


        Schema::create('tax_rates', function ($t) {

            $t->increments('id');
            $t->unsignedInteger('company_id')->index();
            $t->unsignedInteger('user_id')->nullable();
            $t->timestamps(6);
            $t->softDeletes();

            $t->string('name',100)->unique();
            $t->decimal('rate', 13, 3)->default(0);

            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });


        Schema::create('products', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('company_id')->index();
            $t->unsignedInteger('user_id');

            $t->string('custom_value1')->nullable();
            $t->string('custom_value2')->nullable();
            $t->string('custom_value3')->nullable();
            $t->string('custom_value4')->nullable();

            $t->string('product_key')->nullable();
            $t->text('notes')->nullable();
            $t->decimal('cost', 13, 2)->default(0);
            $t->decimal('price', 13, 2)->default(0);
            $t->decimal('quantity', 13, 2)->default(0);

            $t->string('tax_name1')->nullable();
            $t->decimal('tax_rate1', 13, 3)->default(0);
            $t->string('tax_name2')->nullable();
            $t->decimal('tax_rate2', 13, 3)->default(0);
            $t->string('tax_name3')->nullable();
            $t->decimal('tax_rate3', 13, 3)->default(0);

            $t->boolean('is_deleted')->default(false);

            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $t->timestamps(6);
            $t->softDeletes();
        });


        Schema::create('payments', function ($t) {
            $t->increments('id');                                             
            $t->unsignedInteger('company_id')->index();
            $t->unsignedInteger('client_id')->index();
            $t->unsignedInteger('user_id')->nullable();
            $t->unsignedInteger('client_contact_id')->nullable();
            $t->unsignedInteger('invitation_id')->nullable();
            $t->unsignedInteger('company_gateway_id')->nullable();
            $t->unsignedInteger('payment_type_id')->nullable();
            $t->unsignedInteger('status_id')->index();
            $t->decimal('amount', 13, 2)->default(0);
            $t->datetime('payment_date')->nullable();
            $t->string('transaction_reference')->nullable();
            $t->string('payer_id')->nullable();
            $t->timestamps(6);
            $t->softDeletes();
            $t->boolean('is_deleted')->default(false);

            $t->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $t->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $t->foreign('client_contact_id')->references('id')->on('client_contacts')->onDelete('cascade');
            $t->foreign('company_gateway_id')->references('id')->on('company_gateways')->onDelete('cascade');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            ;
            $t->foreign('payment_type_id')->references('id')->on('payment_types');

        });

        Schema::create('paymentables', function ($table) { //allows multiple invoices to one payment
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('paymentable_id');
            $table->string('paymentable_type');
        });

        Schema::create('payment_libraries', function ($t) {
            $t->increments('id');
            $t->timestamps(6);

            $t->string('name')->nullable();
            $t->boolean('visible')->default(true);
        });

        Schema::table('gateways', function ($table) {
            $table->unsignedInteger('payment_library_id')->default(1);
            $table->unsignedInteger('sort_order')->default(10000);
            $table->boolean('recommended')->default(0);
            $table->string('site_url', 200)->nullable();
            $table->boolean('is_offsite')->default(false);
            $table->boolean('is_secure')->default(false);
            $table->text('fields')->nullable();
        });

        DB::table('gateways')->update(['payment_library_id' => 1]);

        Schema::table('gateways', function ($table) {
            $table->foreign('payment_library_id')->references('id')->on('payment_libraries')->onDelete('cascade');
        });

        Schema::create('tasks', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('invoice_id')->nullable();
            $table->timestamps(6);
            $table->softDeletes();

            $table->string('custom_value1')->nullable();
            $table->string('custom_value2')->nullable();

            $table->string('description')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_running')->default(false);
            $table->text('time_log')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });

        Schema::create('banks', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('remote_id')->nullable();
            $table->integer('bank_library_id')->default(1);
            $table->text('config')->nullable();
        });

        Schema::create('bank_companies', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('bank_id');
            $table->unsignedInteger('user_id');
            $table->string('username')->nullable();

            $table->timestamps(6);
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks');

        });


        Schema::create('bank_subcompanies', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('bank_company_id');

            $table->string('account_name')->nullable();
            $table->string('website')->nullable();
            $table->string('account_number')->nullable();

            $table->timestamps(6);
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bank_company_id')->references('id')->on('bank_companies')->onDelete('cascade');

        });

        Schema::create('payment_terms', function ($table) {
            $table->increments('id');
            $table->integer('num_days');
            $table->string('name')->nullable();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('user_id');
            $table->timestamps(6);
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::create('activities', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('client_contact_id')->nullable();
            $table->unsignedInteger('account_id')->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('invitation_id')->nullable();
            $table->unsignedInteger('task_id')->nullable();
            $table->unsignedInteger('expense_id')->nullable();
            $table->unsignedInteger('activity_type_id')->nullable();
            $table->string('ip');
            $table->boolean('is_system')->default(0);

            $table->text('notes');
            $table->timestamps(6);

            $table->index(['user_id', 'company_id']);
            $table->index(['client_id', 'company_id']);
            $table->index(['payment_id', 'company_id']);
            $table->index(['invoice_id', 'company_id']);
            $table->index(['invitation_id', 'company_id']);
            $table->index(['task_id', 'company_id']);
            $table->index(['expense_id', 'company_id']);
            $table->index(['client_contact_id', 'company_id']);

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });

        Schema::create('backups', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id');
            $table->text('json_backup')->nullable();
            $table->timestamps(6);

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');

        });

        Schema::create('company_ledgers', function ($table) {
            
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();

            $table->decimal('adjustment', 13, 2)->nullable();
            $table->decimal('balance', 13, 2)->nullable(); //this is the clients balance carried forward
            $table->text('notes')->nullable();
            $table->text('hash')->nullable();

            $table->unsignedInteger('company_ledgerable_id');
            $table->string('company_ledgerable_type');
            $table->timestamps(6);

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::create('gateway_types', function ($table) {
            $table->increments('id');
            $table->string('alias')->nullable();
            $table->string('name')->nullable();
        });


        Schema::create('client_gateway_tokens', function ($table){
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('client_id')->nullable();
            $table->text('token')->nullable();
            $table->unsignedInteger('company_gateway_id');
            $table->string('gateway_customer_reference')->nullable();
            $table->unsignedInteger('gateway_type_id');
            $table->boolean('is_default')->default(0);
            $table->text('meta')->nullable();
            $table->softDeletes();

            $table->timestamps(6);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::create('group_settings', function ($table){
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->text('settings')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });


        Schema::create('date_formats', function ($table) {
            $table->increments('id');
            $table->string('format');
            $table->string('format_moment');
            $table->string('format_dart');
        });

        Schema::create('datetime_formats', function ($table) {
            $table->increments('id');
            $table->string('format');
            $table->string('format_moment');
            $table->string('format_dart');
        });

        Schema::create('system_log', function ($table){
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('event_id')->nullable();
            $table->text('log');
            $table->timestamps(6);

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });
    }
  
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


    }


}