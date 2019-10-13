<?php
/**
 * @OA\Schema(
 *   schema="CompanySettings",
 *   type="object",
 *       @OA\Property(property="timezone_id", type="string", example="15", description="The timezone id"),
 *       @OA\Property(property="date_format_id", type="string", example="15", description="____________"),
 *       @OA\Property(property="financial_year_start", type="string", example="2000-01-01", description="____________"),
 *       @OA\Property(property="language_id", type="string", example="1", description="____________"),
 *       @OA\Property(property="company_logo", type="string", example="https://example.com/logo.png", description="The URL to the company Logo"),
 *       @OA\Property(property="custom_label1", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_label2", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_label3", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_label4", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_value1", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_value2", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_value3", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_value4", type="string", example="Custom Label", description="____________"),
 *       @OA\Property(property="custom_message_dashboard", type="string", example="Please pay invoices immediately", description="____________"),
 *       @OA\Property(property="custom_message_unpaid_invoice", type="string", example="Please pay invoices immediately", description="____________"),
 *       @OA\Property(property="custom_message_paid_invoice", type="string", example="Thanks for paying this invoice!", description="____________"),
 *       @OA\Property(property="custom_message_unapproved_quote", type="string", example="Please approve quote", description="____________"),
 *       @OA\Property(property="military_time", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="custom_taxes1", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="custom_taxes2", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="send_reminders", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="lock_sent_invoices", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="auto_archive_invoice", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="inclusive_taxes", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="show_tasks_in_portal", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="show_currency_code", type="boolean", example=true, description="____________"),
 *       @OA\Property(property="shared_invoice_quote_counter", type="boolean", example=true, description="Flags whether to share the counter for invoices and quotes"),
 *       @OA\Property(property="first_day_of_week", type="integer", example="1", description="____________"),
 *       @OA\Property(property="invoice_number_prefix", type="string", example="R", description="This string is prepended to the invoice number"),
 *       @OA\Property(property="invoice_number_pattern", type="string", example="{$year}-{$counter}", description="Allows customisation of the invoice number pattern"),
 *       @OA\Property(property="invoice_number_counter", type="integer", example="1", description="____________"),
 *       @OA\Property(property="quote_number_prefix", type="string", example="R", description="This string is prepended to the quote number"),
 *       @OA\Property(property="quote_number_pattern", type="string", example="{$year}-{$counter}", description="Allows customisation of the quote number pattern"),
 *       @OA\Property(property="quote_number_counter", type="integer", example="1", description="____________"),
 *       @OA\Property(property="client_number_prefix", type="string", example="R", description="This string is prepended to the client number"),
 *       @OA\Property(property="client_number_pattern", type="string", example="{$year}-{$counter}", description="Allows customisation of the client number pattern"),
 *       @OA\Property(property="client_number_counter", type="integer", example="1", description="____________"),
 *       @OA\Property(property="credit_number_prefix", type="string", example="R", description="This string is prepended to the credit number"),
 *       @OA\Property(property="credit_number_pattern", type="string", example="{$year}-{$counter}", description="Allows customisation of the credit number pattern"),
 *       @OA\Property(property="credit_number_counter", type="integer", example="1", description="____________"),
 *       @OA\Property(property="recurring_invoice_number_prefix", type="string", example="R", description="This string is prepended to the recurring invoice number"),
 *       @OA\Property(property="default_task_rate", type="number", format="float", example="10.00", description="____________"),
 *       @OA\Property(property="translations", type="object", example="", description="JSON payload of customized translations"),
 *       @OA\Property(property="payment_terms", type="integer", example="1", description="-1 sets no payment term, 0 sets payment due immediately, positive integers indicates payment terms in days"),
 *       @OA\Property(property="reset_counter_frequency_id", type="integer", example="1", description="CONSTANT which is used to apply the frequency which the counters are reset"),
 *       @OA\Property(property="counter_padding", type="integer", example="1", description="Pads the counter with leading zeros"),
 *       @OA\Property(property="default_gateway", type="integer", example="1", description="The default payment gateway"),
 *       @OA\Property(property="reset_counter_date", type="string", example="2019-01-01", description="The explicit date which is used to reset counters"),
 * )
 */
 * 