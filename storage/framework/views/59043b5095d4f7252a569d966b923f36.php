<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas y Rentabilidad</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .subtitulo { font-size: 11px; color: #555; margin-bottom: 12px; }
        .kpis { margin-bottom: 15px; }
        .kpis div { margin-bottom: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        .right { text-align: right; }
        .small { font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <h1>Reporte de Análisis de Ventas y Rentabilidad</h1>
    <div class="subtitulo">
        Periodo:
        <strong><?php echo e($desde->format('d/m/Y')); ?></strong>
        al
        <strong><?php echo e($hasta->format('d/m/Y')); ?></strong>
        <?php if($categoria): ?>
            | Categoría: <strong><?php echo e(ucfirst($categoria)); ?></strong>
        <?php endif; ?>
        <?php if($estado): ?>
            | Estado: <strong><?php echo e(ucfirst($estado)); ?></strong>
        <?php endif; ?>
    </div>

    <div class="kpis">
        <div><strong>Total de pedidos:</strong> <?php echo e($totalPedidos); ?></div>
        <div><strong>Ingresos totales:</strong> Bs. <?php echo e(number_format($totalIngresos, 2)); ?></div>
        <div><strong>Ticket promedio:</strong> Bs. <?php echo e(number_format($ticketPromedio, 2)); ?></div>
        <div><strong>Tasa de conversión:</strong> <?php echo e(number_format($tasaConversion, 2)); ?>%</div>
    </div>

    <h3>Ventas por categoría</h3>
    <table>
        <thead>
        <tr>
            <th>Categoría</th>
            <th class="right">Pedidos</th>
            <th class="right">Cantidad</th>
            <th class="right">Ingresos (Bs.)</th>
            <th class="right">Precio promedio (Bs.)</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $ventasPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(ucfirst($fila->categoria)); ?></td>
                <td class="right"><?php echo e($fila->total_pedidos); ?></td>
                <td class="right"><?php echo e($fila->total_cantidad); ?></td>
                <td class="right"><?php echo e(number_format($fila->ingresos_totales, 2)); ?></td>
                <td class="right"><?php echo e(number_format($fila->precio_promedio, 2)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p class="small">
        Generado el <?php echo e(now()->format('d/m/Y H:i')); ?> - Mercado Agrícola
    </p>
</body>
</html>
<?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/reportes/ventas_pdf.blade.php ENDPATH**/ ?>