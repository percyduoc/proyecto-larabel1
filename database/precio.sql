SELECT 
    c.id AS id_cuenta,
    c.nombre AS nombre_cuenta,
    SUM(dc.valor_producto * dc.cantidad_producto) AS total_cuenta
FROM 
    cuentas AS c
JOIN 
    detalle_cuentas AS dc ON c.id = dc.id_cuenta
WHERE 
    c.id = 1
GROUP BY 
    c.id, c.nombre;

