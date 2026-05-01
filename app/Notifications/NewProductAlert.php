<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProductAlert extends Notification
{
    use Queueable;

    public function __construct(public Product $product)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'title' => 'New product listed: ' . $this->product->name,
            'category' => $this->product->category,
            'price' => $this->product->price,
            'image' => $this->product->image,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Product Alert: ' . $this->product->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new product has been added that matches your alert preferences:')
            ->line('Product: ' . $this->product->name)
            ->line('Category: ' . $this->product->category)
            ->line('Price: ₹' . $this->product->price)
            ->action('View Product', url(route('products.show', $this->product->id)))
            ->line('Thank you for using Farmer Market!');
    }
}
