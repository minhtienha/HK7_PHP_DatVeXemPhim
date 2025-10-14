# TODO: Fix MoMo Callback Session Issue

## Problem

-   MoMo callback cannot read session data because it's a separate request.
-   Currently, data is stored in session, but callback redirects to /phim without creating ticket.
-   Need to store ticket data in MoMo's extraData and retrieve it in callback.

## Plan

1. Modify ThanhToanController::momo_payment to encode session data (ve_tam_thoi and danh_sach_ghe_tam) into JSON, base64, and set as extraData.
2. Change redirectUrl to route('tao_ve') so after payment, user is redirected to /tao_ve with GET params.
3. Update VeController::TaoVe_ChiTietVe to handle GET (redirect) by decoding extraData, creating ticket if resultCode=0, then redirect to /phim.
4. Ensure IPN (POST) also works similarly.
5. Clear session after successful ticket creation.

## Steps

-   [x] Update ThanhToanController::momo_payment: encode data to extraData, change redirectUrl.
-   [x] Update VeController::TaoVe_ChiTietVe: add logic for GET request to decode extraData and create ticket.
-   [x] Update routes to allow GET and POST for /tao_ve.
-   [ ] Test the flow.
