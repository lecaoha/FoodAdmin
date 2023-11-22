package com.myappfood.appfood.Common;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;


import com.myappfood.appfood.Model.User;

public class Common {
    public static User currentUser;

    public static String PHONE_TEXT = "userPhone";

    public static final String INTENT_FOOD_ID = "FoodId";

    public static String convertCodeToStatus(String status){
        if (status.equals("0"))
            return "Đang xử lý";
        else if (status.equals("1"))
            return "Đang giao";
        else if (status.equals("2"))
            return "Giao thành công";
        else
            return "Đơn hàng đã huỷ";
    }

    public static final String DELETE ="Delete";
    public static boolean isConnectedToInterner(Context context) {
    ConnectivityManager connectivityManager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
    NetworkInfo[] info = connectivityManager.getAllNetworkInfo();
    if (info != null) {
        for (int i = 0; i < info.length; i++) {
            if (info[i].getState() == NetworkInfo.State.CONNECTED) {
                return true;
            }
        }
    }
    return false;
}
}
