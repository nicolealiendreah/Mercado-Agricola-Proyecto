<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Productos con Bajo Movimiento</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #555; padding: 4px 6px; }
        th { background: #e0e0e0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Reporte de Productos con Bajo Movimiento</h1>
    <p>
        Periodo:
        <strong><?php echo e($desde->format('d/m/Y')); ?></strong>
        al
        <strong><?php echo e($hasta->format('d/m/Y')); ?></strong><br>
        Máx. ventas para considerar lento: <strong><?php echo e($minVentas); ?></strong>
    </p>

    <p>
        Total productos: <strong><?php echo e($totalProductos); ?></strong><br>
        Sin ventas: <strong><?php echo e($sinVentas); ?></strong><br>
        Con pocas ventas: <strong><?php echo e($conPocasVentas); ?></strong>
    </p>

    <table>
        <thead>
        <tr>
            <th>Categoría</th>
            <th>Producto</th>
            <th>Vendedor</th>
            <th class="text-right">Precio (Bs.)</th>
            <th class="text-right">Total vendido</th>
            <th class="text-right">Ingresos (Bs.)</th>
            <th>Última venta</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($p->categoria); ?></td>
                <td><?php echo e($p->producto); ?></td>
                <td><?php echo e($p->vendedor); ?></td>
                <td class="text-right"><?php echo e(number_format($p->precio, 2)); ?></td>
                <td class="text-right"><?php echo e($p->total_vendido); ?></td>
                <td class="text-right"><?php echo e(number_format($p->ingresos, 2)); ?></td>
                <td>
                    <?php if($p->ultima_venta): ?>
                        <?php echo e(\Carbon\Carbon::parse($p->ultima_venta)->format('d/m/Y')); ?>

                    <?php else: ?>
                        Sin ventas
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p class="small">
        Generado el <?php echo e(now()->format('d/m/Y H:i')); ?> - Mercado Agrícola
    </p>
</body>
</html>
<?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/reportes/productos_lentos_pdf.blade.php ENDPATH**/ ?>