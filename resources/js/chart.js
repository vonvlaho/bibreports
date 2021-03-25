const height = 600, width = 960;
const margin = ({top: 10, right: 10, bottom: 200, left: 40})

const svg = d3.select("#dataChart").append("svg")
    .attr("viewBox", [0, 0, width, height]);

data = data.slice(0, 19)

const columns = []
for (var key in data[0]) {
    if (data[0].hasOwnProperty(key)
        && key !== 'id'
        && key !== 'total'
        && key !== 'name') {
        columns.push(key);
    }
}
const series = d3.stack()
    .keys(columns)
    (data)
    .map(d => (d.forEach(v => v.key = d.key), d))

const x = d3.scaleBand()
    .domain(data.map(d => d.name))
    .range([margin.left, width - margin.right])
    .padding(0.1)

const y = d3.scaleLinear()
    .domain([0, d3.max(series, d => d3.max(d, d => d[1]))])
    .rangeRound([height - margin.bottom, margin.top])

const color = d3.scaleOrdinal()
    .domain(series.map(d => d.key))
    .range(d3.schemeTableau10)
    .unknown("#ccc")

const xAxis = g => g
    .style("font-size", "1em")
    .attr("transform", `translate(0,${height - margin.bottom})`)
    .call(d3.axisBottom(x).tickSizeOuter(0))
    .call(g => g.selectAll(".domain").remove())

const yAxis = g => g
    .style("font-size", "1em")
    .attr("transform", `translate(${margin.left},0)`)
    .call(d3.axisLeft(y).ticks(null, "s"))
    .call(g => g.selectAll(".domain").remove())

svg.append("g")
    .selectAll("g")
    .data(series)
    .join("g")
    .attr("fill", d => color(d.key))
    .selectAll("rect")
    .data(d => d)
    .join("rect")
    .attr("x", (d, i) => x(d.data.name))
    .attr("y", d => y(d[1]))
    .attr("height", d => y(d[0]) - y(d[1]))
    .attr("width", x.bandwidth())
    .append("title")
    .text(d => `${d[1] - d[0]}`)

svg.append("g")
    .call(xAxis)
    .selectAll("text")
    .style("text-anchor", "end")
    .attr("dx", "-.8em")
    .attr("dy", ".15em")
    .attr("transform", "rotate(-65)" )

svg.append("g")
    .call(yAxis)

legend = svg => {
    const g = svg
        .attr("transform", `translate(${width},0)`)
        .attr("text-anchor", "end")
        .style("font-size", "1em")
        .selectAll("g")
        .data(color.domain().slice().reverse())
        .join("g")
        .attr("transform", (d, i) => `translate(0,${i * 20})`);

    g.append("rect")
        .attr("x", -19)
        .attr("width", 19)
        .attr("height", 19)
        .attr("fill", color);

    g.append("text")
        .attr("x", -24)
        .attr("y", 9.5)
        .attr("dy", "0.35em")
        .text(d => d.substring(2));
}

svg.append("g")
    .call(legend);
