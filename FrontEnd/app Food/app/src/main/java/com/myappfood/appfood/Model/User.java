package com.myappfood.appfood.Model;

public class User {
    private String Name;
    private String Password;
    private String Phone;
    private String IsStaff;
    private String Admin;
    private String PhoneNumber;

    public User(){

    }

    public User(String name, String password , String phonenumber) {
        Name = name;
        Password = password;
        PhoneNumber = phonenumber;
        IsStaff ="false";
        Admin ="false";

    }

    public String getPhoneNumber() {
        return PhoneNumber;
    }

    public void setPhoneNumber(String phoneNumber) {
        PhoneNumber = phoneNumber;
    }

    public String getIsStaff() {
        return IsStaff;
    }

    public void setIsStaff(String isStaff) {
        IsStaff = isStaff;
    }

    public String getPhone() {
        return Phone;
    }

    public void setPhone(String phone) {
        Phone = phone;
    }

    public String getName() {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public String getPassword() {
        return Password;
    }

    public void setPassword(String password) {
        Password = password;
    }

    public String getAdmin() {
        return Admin;
    }

    public void setAdmin(String admin) {
        Admin = admin;
    }
}
