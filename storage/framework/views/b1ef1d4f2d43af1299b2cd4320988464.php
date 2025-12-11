<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Rendimiento de Vendedores</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 11px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 4px;
        }
        .subtitulo {
            font-size: 12px;
            color: #555;
            margin-bottom: 15px;
        }
        .kpi-box {
            border: 1px solid #cccccc;
            border-radius: 4px;
            padding: 6px 8px;
            margin-bottom: 8px;
        }
        .kpi-label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cccccc;
            padding: 4px 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tfoot td {
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .small { font-size: 9px; color: #777; }
    </style>
</head>
<body>
    <h1>Reporte de Rendimiento de Vendedores</h1>
    <div class="subtitulo">
        Período:
        <?php echo e($desde->format('d/m/Y')); ?> a <?php echo e($hasta->format('d/m/Y')); ?>

    </div>

    <div class="kpi-box">
        <div><span class="kpi-label">Total vendedores:</span> <?php echo e($totalVendedores); ?></div>
        <div><span class="kpi-label">Total productos publicados:</span> <?php echo e($totalProductos); ?></div>
        <div><span class="kpi-label">Ventas totales:</span> Bs. <?php echo e(number_format($ventasTotales, 2, ',', '.')); ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Vendedor</th>
                <th>Email</th>
                <th class="text-center">Total productos</th>
                <th class="text-center">Animales</th>
                <th class="text-center">Maquinaria</th>
                <th class="text-center">Orgánicos</th>
                <th class="text-right">Ventas totales (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $rendimientoVendedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td><?php echo e($v['nombre']); ?></td>
                    <td><?php echo e($v['email']); ?></td>
                    <td class="text-center"><?php echo e($v['total_productos']); ?></td>
                    <td class="text-center"><?php echo e($v['total_ganados']); ?></td>
                    <td class="text-center"><?php echo e($v['total_maquinarias']); ?></td>
                    <td class="text-center"><?php echo e($v['total_organicos']); ?></td>
                    <td class="text-right">Bs. <?php echo e(number_format($v['total_ventas'], 2, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center">No hay datos para el período seleccionado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="small">
        Generado el <?php echo e(now()->format('d/m/Y H:i')); ?> - Mercado Agrícola
    </p>
</body>
</html>
<?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/reportes/vendedores_pdf.blade.php ENDPATH**/ ?>