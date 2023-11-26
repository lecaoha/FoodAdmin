package com.myappfood.appfood.ViewHolder;

import android.view.View;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.widget.AppCompatButton;
import androidx.recyclerview.widget.RecyclerView;

import com.myappfood.appfood.Interface.ItemClickListener;
import com.myappfood.appfood.R;

public class OrderViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {

    public TextView txtOrderId,txtOrderStatus,txtOrderPhone,txtOrderAddress,orderDate,order_total;
    public AppCompatButton btndeleteOrder;
    private ItemClickListener itemClickListener;

    public OrderViewHolder(@NonNull View itemView) {
        super(itemView);
        txtOrderId=(TextView) itemView.findViewById(R.id.order_id);
        txtOrderAddress=(TextView) itemView.findViewById(R.id.order_address);
        txtOrderPhone=(TextView) itemView.findViewById(R.id.order_phone);
        txtOrderStatus=(TextView) itemView.findViewById(R.id.order_status);
        btndeleteOrder = itemView.findViewById(R.id.btndeleteOrder);
        orderDate= (TextView)itemView.findViewById(R.id.orderDate);
        order_total=(TextView)itemView.findViewById(R.id.order_total);

        // Set a click listener for the delete button
        btndeleteOrder.setOnClickListener(this);
        itemView.setOnClickListener(this);
    }

    public void setItemClickListener(ItemClickListener itemClickListener) {
        this.itemClickListener = itemClickListener;
    }
    public OrderViewHolder(@NonNull View itemView, ItemClickListener itemClickListener) {
        super(itemView);
        this.itemClickListener = itemClickListener;
    }

    @Override
    public void onClick(View view) {
        if (itemClickListener != null) {
            itemClickListener.onClick(view, getAdapterPosition(), false);
            btndeleteOrder.setEnabled(false);
            btndeleteOrder.setVisibility(View.GONE);
        }
    }
}
