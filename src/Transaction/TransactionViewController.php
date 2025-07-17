<?php declare(strict_types=1);

namespace Perfin\Transaction;

use Perfin\Core\Models\TransactionModel;
use Perfin\Core\Template\TemplateController;

final class TransactionViewController {
  public static function transactions(): void {
    echo new TemplateController()->engine->render('page/transactions', [
      'transactions' => TransactionModel::all()
    ]);
  }
}