export function asUrlParams(data: Record<string, any>) {
  const urlSearhParams = new URLSearchParams(data);
  const queryString = urlSearhParams.toString();
  return queryString;
}
