# FinTech Services Overview

**Prepared by:** Sarvesh Pal  
**Position:** Full Stack Developer  
**Company:** CodeGraphi Technology Pvt Ltd  

This document provides a comprehensive overview of various FinTech services including AEPS, DMT, Payout, BBPS, and more. It serves as a reference for understanding the purpose, process, and key points for integrating each service in FinTech applications.

---

## Table of Contents

- [AEPS (Aadhaar Enabled Payment System)](#aeps)
- [DMT (Domestic Money Transfer)](#dmt)
- [Payout Services](#payout-services)
- [BBPS (Bharat Bill Payment System)](#bbps)
- [Recharge Services](#recharge-services)
- [PAN Card Services](#pan-card-services)
- [Micro ATM](#micro-atm)
- [Loan Services](#loan-services)
- [Insurance Services](#insurance-services)
- [eKYC / CKYC](#ekyc--ckyc)
- [UPI Services](#upi-services)
- [AADHAAR Pay](#aadhaar-pay)
- [Digital Onboarding (KYC)](#digital-onboarding-kyc)

---

## AEPS

**AEPS** enables basic banking transactions using Aadhaar number and biometric authentication.

- **Services Offered**:
  - Balance Inquiry
  - Cash Withdrawal
  - Mini Statement
  - Aadhaar to Aadhaar Fund Transfer

- **Requirements**:
  - Aadhaar Number
  - Bank Mapping with Aadhaar
  - Biometric Device (e.g., Morpho, Mantra)

- **Key APIs**:
  - `/aeps/initiate`
  - `/aeps/withdraw`
  - `/aeps/balance`
  - `/aeps/statement`

---

## DMT

**Domestic Money Transfer (DMT)** allows users to send money to any Indian bank account in real-time.

- **Features**:
  - Instant Bank Transfers
  - Beneficiary Registration
  - Transaction Tracking

- **Key APIs**:
  - `/dmt/register-sender`
  - `/dmt/add-beneficiary`
  - `/dmt/transfer`
  - `/dmt/status`

---

## Payout Services

**Payout** refers to automated and bulk disbursement of money to beneficiaries.

- **Use Cases**:
  - Salary Disbursement
  - Vendor Payments
  - Refunds and Cashbacks

- **Transfer Modes**:
  - IMPS
  - NEFT
  - UPI

- **Key APIs**:
  - `/payout/transfer`
  - `/payout/status`
  - `/payout/balance`

---

## BBPS

**Bharat Bill Payment System (BBPS)** enables bill payments across multiple categories.

- **Supported Bills**:
  - Electricity
  - Gas
  - Water
  - DTH
  - Telecom
  - Loan EMIs

- **Key APIs**:
  - `/bbps/fetch-billers`
  - `/bbps/fetch-bill`
  - `/bbps/pay-bill`
  - `/bbps/status`

---

## Recharge Services

**Recharge APIs** allow prepaid mobile and DTH recharges.

- **Services**:
  - Mobile Recharge
  - DTH Recharge
  - Data Card Recharge

- **Key APIs**:
  - `/recharge/mobile`
  - `/recharge/dth`
  - `/recharge/status`

---

## PAN Card Services

**PAN Card API** integration allows new PAN registration, correction, and status tracking.

- **Services**:
  - New PAN Card Application
  - PAN Correction
  - Application Status

- **Key APIs**:
  - `/pan/apply`
  - `/pan/correction`
  - `/pan/status`

---

## Micro ATM

Micro ATM allows cash withdrawals via debit card and PIN.

- **Devices**: POS Machines  
- **Authentication**: Card Swipe + PIN

- **Key APIs**:
  - `/microatm/initiate`
  - `/microatm/withdraw`
  - `/microatm/status`

---

## Loan Services

**Loan APIs** allow loan application, verification, and disbursal tracking.

- **Types**:
  - Personal Loan
  - Business Loan
  - Micro Loan

- **Key APIs**:
  - `/loan/apply`
  - `/loan/verify`
  - `/loan/status`

---

## Insurance Services

**Insurance APIs** provide access to multiple insurance products.

- **Categories**:
  - Life Insurance
  - Health Insurance
  - Travel Insurance
  - Motor Insurance

- **Key APIs**:
  - `/insurance/products`
  - `/insurance/apply`
  - `/insurance/status`

---

## eKYC / CKYC

eKYC helps in user identity verification using Aadhaar or PAN.

- **Methods**:
  - OTP-based
  - Biometric-based
  - DigiLocker Integration

- **Key APIs**:
  - `/ekyc/initiate`
  - `/ekyc/verify`
  - `/ckyc/fetch`

---

## UPI Services

Unified Payments Interface (UPI) allows instant peer-to-peer transfers.

- **Features**:
  - Virtual Payment Address (VPA)
  - UPI Collect and Pay
  - UPI AutoPay (Mandates)

- **Key APIs**:
  - `/upi/send`
  - `/upi/collect`
  - `/upi/status`

---

## Aadhaar Pay

Aadhaar Pay enables merchants to accept payments using a customer’s Aadhaar number and biometric.

- **Process**:
  - Enter Aadhaar Number
  - Select Bank
  - Capture Biometric

- **Key APIs**:
  - `/aadhaarpay/initiate`
  - `/aadhaarpay/collect`

---

## Digital Onboarding (KYC)

Enables seamless onboarding of customers and merchants.

- **Steps**:
  - Document Upload
  - Video KYC
  - PAN & Aadhaar Verification

- **Key APIs**:
  - `/kyc/start`
  - `/kyc/upload`
  - `/kyc/verify`

---

## Conclusion

FinTech APIs simplify the integration of essential financial services into applications. Each service plays a crucial role in enabling digital finance, improving accessibility, and empowering users.

> 🔒 Always use secure authentication and encryption while integrating financial APIs.

---

**Prepared by:**  
**Sarvesh Pal**  
**Full Stack Developer**  
**CodeGraphi Technology Pvt Ltd**
