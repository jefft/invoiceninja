<?php
/**
 * @OA\Schema(
 *   schema="Client",
 *   type="object",
 *       @OA\Property(property="id", type="string", example="Opnel5aKBz", description="_________"),
 *       @OA\Property(property="user_id", type="string", example="", description="__________"),
 *       @OA\Property(property="company_id", type="string", example="", description="________"),
 *       @OA\Property(property="client_id", type="string", example="", description="________"),
 *       @OA\Property(
 *       	property="contacts", 
 *        	type="array",
 *        	@OA\Items(
 *          	
 *           	ref="#/components/schemas/ClientContact",
 *          ),
 *       ),
 *       @OA\Property(property="name", type="string", example="", description="________"),
 *       @OA\Property(property="website", type="string", example="", description="________"),
 *       @OA\Property(property="private_notes", type="string", example="", description="________"),
 *       @OA\Property(property="client_hash", type="string", example="", description="________"),
 *       @OA\Property(property="industry_id", type="string", example="", description="________"),
 *       @OA\Property(property="size_id", type="string", example="", description="________"),
 *       @OA\Property(property="address1", type="string", example="", description="________"),
 *       @OA\Property(property="address2", type="string", example="", description="________"),
 *       @OA\Property(property="city", type="string", example="", description="________"),
 *       @OA\Property(property="state", type="string", example="", description="________"),
 *       @OA\Property(property="postal_code", type="string", example="", description="________"),
 *       @OA\Property(property="country_id", type="string", example="", description="________"),
 *       @OA\Property(property="custom_value1", type="string", example="", description="________"),
 *       @OA\Property(property="custom_value2", type="string", example="", description="________"),
 *       @OA\Property(property="custom_value3", type="string", example="", description="________"),
 *       @OA\Property(property="custom_value4", type="string", example="", description="________"),
 *       @OA\Property(property="vat_number", type="string", example="", description="________"),
 *       @OA\Property(property="id_number", type="string", example="", description="________"),
 *       @OA\Property(property="shipping_address1", type="string", example="", description="________"),
 *       @OA\Property(property="shipping_address2", type="string", example="", description="________"),
 *       @OA\Property(property="shipping_city", type="string", example="", description="________"),
 *       @OA\Property(property="shipping_state", type="string", example="", description="________"),
 *       @OA\Property(property="shipping_postal_code", type="string", example="", description="________"),
 *       @OA\Property(property="shipping_country_id", type="string", example="", description="________"),
 *       @OA\Property(property="is_deleted", type="boolean", example=true, description="________"),
 *       @OA\Property(property="balance", type="number", format="float", example="10.00", description="________"),
 *       @OA\Property(property="paid_to_date", type="number", format="float", example="10.00", description="________"),
 *       @OA\Property(property="last_login", type="number", format="integer", example="134341234234", description="Timestamp"),
 *       @OA\Property(property="created_at", type="number", format="integer", example="134341234234", description="Timestamp"),
 *       @OA\Property(property="updated_at", type="number", format="integer", example="134341234234", description="Timestamp"),
 *       @OA\Property(property="settings",ref="#/components/schemas/CompanySettings"),
 * )
 */