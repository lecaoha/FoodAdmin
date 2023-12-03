package com.myappfood.appfood.ViewHolder;

import android.content.Context;
import android.graphics.Color;
import android.icu.number.CompactNotation;
import android.view.ContextMenu;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.amulyakhare.textdrawable.TextDrawable;
import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton;
import com.myappfood.appfood.Cart;
import com.myappfood.appfood.Common.Common;
import com.myappfood.appfood.Database.Database;
import com.myappfood.appfood.Interface.ItemClickListener;
import com.myappfood.appfood.Model.Order;
import com.myappfood.appfood.R;
import com.squareup.picasso.Picasso;

import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

class CartViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener
     ,View.OnCreateContextMenuListener{
    public TextView txt_cart_name,txt_price;
    public ElegantNumberButton btn_quantity;
    public ImageView cart_image;

    private ItemClickListener itemClickListener;


    public void setTxt_cart_name(TextView txt_cart_name) {
        this.txt_cart_name = txt_cart_name;
    }

    public CartViewHolder(@NonNull View itemView) {
        super(itemView);
        txt_cart_name=(TextView) itemView.findViewById(R.id.cart_item_name);
        txt_price=(TextView) itemView.findViewById(R.id.cart_item_price);
        btn_quantity=(ElegantNumberButton) itemView.findViewById(R.id.btn_quantity);
        cart_image=(ImageView)itemView.findViewById(R.id.cart_image);
        itemView.setOnCreateContextMenuListener(this);
    }

    @Override
    public void onClick(View v) {

    }

    @Override
    public void onCreateContextMenu(ContextMenu contextMenu, View v, ContextMenu.ContextMenuInfo contextMenuInfo) {
       contextMenu.setHeaderTitle("Select action");
       contextMenu.add(0,0,getAdapterPosition(), Common.DELETE);
    }
}
public class CartAdapter extends RecyclerView.Adapter<CartViewHolder>{

    private List<Order> listData= new ArrayList<>();
    private Cart cart;

    public CartAdapter(List<Order> listData, Cart cart) {
        this.listData = listData;
        this.cart = cart;
    }

    @NonNull
    @Override
    public CartViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater inflater= LayoutInflater.from(cart);
        View itemView= inflater.inflate(R.layout.cart_layout,parent,false);
        return new CartViewHolder(itemView);

    }

    @Override
    public void onBindViewHolder(@NonNull CartViewHolder holder, int position) {
//        TextDrawable drawable= TextDrawable.builder().buildRound(""+listData.get(position).getQuantity(), Color.RED);
//        holder.btn_quantity.setImageDrawable(drawable);
        Picasso.with(cart.getBaseContext())
                .load(listData.get(position).getImage())
                .resize(70,70)
                .into(holder.cart_image);
        holder.btn_quantity.setNumber(listData.get(position).getQuantity());
        holder.btn_quantity.setOnValueChangeListener(new ElegantNumberButton.OnValueChangeListener() {
            @Override
            public void onValueChange(ElegantNumberButton view, int oldValue, int newValue) {
                Order order = listData.get(position);
                order.setQuantity(String.valueOf(newValue));
                new Database(cart).updateCart(order);

                // Update txtTotalPrice
                int total = 0;
                List<Order> orders = new Database(cart).getCart();
                for (Order item : orders) {
                    String priceWithoutComma = item.getPrice().replaceAll(",", "");
                    total += (Integer.parseInt(priceWithoutComma)) * (Integer.parseInt(item.getQuantity()));
                }

                Locale locale = new Locale("vi", "VN");
                NumberFormat fmt = NumberFormat.getCurrencyInstance(locale);

                // Format the total with dots as the decimal separator
                String formattedTotal = fmt.format(total);
                formattedTotal = formattedTotal.replace("₫", ""); // Remove the currency symbol
                formattedTotal = formattedTotal.replace(",", ".");  // Replace commas with dots

                cart.txtTotalPrice.setText(formattedTotal);
            }
        });
        String priceWithoutComma = listData.get(position).getPrice().replaceAll(",", "");
        int price = Integer.parseInt(priceWithoutComma) * Integer.parseInt(listData.get(position).getQuantity());

        Locale locale = new Locale("vi", "VN");
        NumberFormat fmt = NumberFormat.getCurrencyInstance(locale);

        // Format the price with dots as the decimal separator
        String formattedPrice = fmt.format(price);
        formattedPrice = formattedPrice.replace(",", ".");  // Replace commas with dots

        holder.txt_price.setText(formattedPrice);
        holder.txt_cart_name.setText(listData.get(position).getProductName());
    }

    @Override
    public int getItemCount() {
        return listData.size();
    }
}
